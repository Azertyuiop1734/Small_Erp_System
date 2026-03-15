<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
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
        'items.*.barcode' => 'required',
        'items.*.boxes_count' => 'required|numeric|min:1',
        'items.*.units_per_box' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric',
    ]);

    DB::transaction(function () use ($request) {
        // 2. إنشاء رأس الفاتورة
        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'user_id' => auth()->id() ?? 1, 
            'warehouse_id' => $request->warehouse_id,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'remaining_amount' => $request->total_amount - $request->paid_amount,
            'purchase_date' => $request->purchase_date,
        ]);

        foreach ($request->items as $item) {
            // 3. تحديث أو إنشاء المنتج (بيانات أساسية فقط)
            // ملاحظة: تم حذف units_per_box من هنا لأنها انتقلت للمخزن
            $product = Product::updateOrCreate(
                ['barcode' => $item['barcode']], 
                [
                    'name' => $item['product_name'] ?? 'منتج جديد ' . $item['barcode'],
                    'category_id' => $item['category_id'] ?? 1,
                    
                    'selling_price' => $item['selling_price'] ?? ($item['price'] * 1.5),
                ]
            );

            // 4. تسجيل تفاصيل الصناديق في عنصر الشراء (للتوثيق التاريخي)
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id, 
                'quantity' => $item['quantity'], // الكمية الكلية (عدد الصناديق * الوحدات)
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
                'boxes_count' => $item['boxes_count'],
                'units_per_box' => $item['units_per_box'],
            ]);

            // 5. تحديث المخزون في الجدول الوسيط (product_warehouse)
            // هذا هو المكان الصحيح لعدد الصناديق والوحدات حالياً
            $stock = ProductWarehouse::firstOrNew([
                'product_id' => $product->id,
                'warehouse_id' => $request->warehouse_id
            ]);

            // إضافة الكميات الجديدة للقيم القديمة
            $stock->quantity += $item['quantity'];
            $stock->boxes_count += $item['boxes_count'];
            $stock->units_per_box = $item['units_per_box']; // تحديث معامل التحويل لأحدث قيمة
            
            $stock->save();
        }
    });

    return redirect()->back()->with('success', 'تم تسجيل المشتريات وتحديث المخزون بنجاح');
}


    public function getProductByBarcode($barcode)
    {
 
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



public function index()
{
    $purchases = Purchase::with(['supplier', 'warehouse'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.stores.purchases', compact('purchases'));
}


public function show($id)
{

    $purchase = DB::table('purchases')
        ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
        ->join('warehouses', 'purchases.warehouse_id', '=', 'warehouses.id')
        ->where('purchases.id', $id)
        ->select('purchases.*', 'suppliers.name as supplier_name', 'warehouses.name as warehouse_name')
        ->first();


    $items = DB::table('purchase_items')
        ->join('products', 'purchase_items.product_id', '=', 'products.id')
        ->where('purchase_items.purchase_id', $id)
        ->select('purchase_items.*', 'products.name as product_name', 'products.barcode')
        ->get();

    return view('admin.stores.purchases_details', compact('purchase', 'items'));
}
  
}
