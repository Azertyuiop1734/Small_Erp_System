<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\ProductWarehouse;
use App\Models\Supplier;
use App\Models\Warehouses;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function create()
    {
        $suppliers = Supplier::all();
        $warehouses = Warehouses::all();
        $products = Product::all();
        return view('admin.stores.add_purchase', compact('suppliers', 'warehouses', 'products'));
    }

    public function store(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'supplier_id' => 'required',
            'warehouse_id' => 'required',
            'purchase_date' => 'required|date',
            'items' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            // 2. إنشاء سجل المشتريات الرئيسي
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => 2, // تأكد من تسجيل الدخول
                'warehouse_id' => $request->warehouse_id,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'remaining_amount' => $request->total_amount - $request->paid_amount,
                'purchase_date' => $request->purchase_date,
            ]);

            foreach ($request->items as $item) {
                // 1. التعامل مع جدول المنتجات (الرئيسي)
                // نبحث عن المنتج بالباركود، إذا وجده يأخذه، وإذا لم يجده ينشئه
                $product = Product::firstOrCreate(
                    ['barcode' => $item['barcode']], // شرط البحث
                    [
                        'name' => $item['product_name'] ?? 'منتج جديد ' . $item['barcode'],
                        'category_id' => $item['category_id'] ?? 1,
                        'selling_price' => $item['selling_price'] ?? ($item['price'] * 1.5),
                    ]
                );

                // 2. إضافة العناصر لجدول purchase_items
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id, // استخدم ID المنتج الذي حصلنا عليه أعلاه
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);

                // 3. تحديث كمية المخزن (ProductWarehouse)
                // نبحث هل هذا المنتج موجود في هذا المخزن "تحديداً"؟
                $stock = ProductWarehouse::where('product_id', $product->id)
                    ->where('warehouse_id', $request->warehouse_id)
                    ->first();

                if ($stock) {
                    // إذا كان موجوداً في هذا المخزن، نزيد الكمية
                    $stock->increment('quantity', $item['quantity']);
                } else {
                    // إذا كان المنتج موجوداً في النظام ولكن لأول مرة يدخل هذا المخزن
                    ProductWarehouse::create([
                        'product_id' => $product->id,
                        'warehouse_id' => $request->warehouse_id,
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'تم تسجيل المشتريات وتحديث المخزون بنجاح');
    }


    public function getProductByBarcode($barcode)
    {
        // تنظيف الباركود من أي مسافات زائدة
        $cleanBarcode = trim($barcode);

        $product = Product::where('barcode', $cleanBarcode)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }

        return response()->json(['success' => false], 404);
    }


 // عرض كل المشتريات مع عمل Join للجداول يدوياً
public function index()
{
    $purchases = DB::table('purchases')
    ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
    ->join('warehouses', 'purchases.warehouse_id', '=', 'warehouses.id')
    ->select(
        'purchases.*', 
        'suppliers.name as supplier_name',   // هذا هو الاسم الذي سنستخدمه
        'warehouses.name as warehouse_name' // وهذا أيضاً
    )
    ->orderBy('purchases.created_at', 'desc')
    ->get();

    return view('admin.stores.purchases', compact('purchases'));
}

// عرض تفاصيل فاتورة محددة
public function show($id)
{
    // جلب بيانات الفاتورة الأساسية
    $purchase = DB::table('purchases')
        ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
        ->join('warehouses', 'purchases.warehouse_id', '=', 'warehouses.id')
        ->where('purchases.id', $id)
        ->select('purchases.*', 'suppliers.name as supplier_name', 'warehouses.name as warehouse_name')
        ->first();

    // جلب العناصر المرتبطة بهذه الفاتورة
    $items = DB::table('purchase_items')
        ->join('products', 'purchase_items.product_id', '=', 'products.id')
        ->where('purchase_items.purchase_id', $id)
        ->select('purchase_items.*', 'products.name as product_name', 'products.barcode')
        ->get();

    return view('admin.stores.purchases_details', compact('purchase', 'items'));
}
  
}
