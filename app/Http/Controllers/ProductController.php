<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Warehouses;
use App\Models\Product;
use App\Models\ProductWarehouse;

class ProductController extends Controller
{

    public function create()
    {

        $categories = Category::all();
        $warehouses = Warehouses::all();
        return view('admin.stores.add_product', compact('categories', 'warehouses'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|unique:products,barcode',
            'category_id' => 'required|numeric',

            'warehouse_id' => 'required|numeric',
            'initial_quantity' => 'required|integer|min:0',

            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $imagePath = null;
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('products', 'public');
                }




                $product = Product::create([
                    'name' => $request->name,
                    'barcode' => $request->barcode,
                    'category_id' => $request->category_id,
                    'selling_price' => $request->selling_price,
                    'image' => $imagePath,
                    'minimum_stock' => $request->minimum_stock ?? 5,
                ]);

                $productId = $product->id;

                ProductWarehouse::create([
                    'product_id' => $productId,
                    'warehouse_id' => $request->warehouse_id,
                    'quantity' => $request->initial_quantity,
                    'minimum_stock' => $request->minimum_stock ?? 5,
                ]);
            });

            return redirect()->back()->with('success', 'تم تسجيل المنتج بنجاح في النظام والمخزن.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error_message', 'فشل الحفظ: ' . $e->getMessage());
        }
    }
    public function index(Request $request)
{
    try {
        // 1. جلب المخازن القابلة للعرض فقط (للقائمة المنسدلة)
        $warehouses = Warehouses::where('display', 1)->get();
        
        // 2. تحديث الإحصائيات بحيث تشمل المنتجات والمخازن النشطة فقط
        $totalProductsCount = Product::where('display', 1)->count();
        $warehousesCount = $warehouses->count();

        // 3. تحديث حساب النواقص (Low Stock) بحيث يشمل فقط المنتجات التي لها display = 1
        $lowStockCount = ProductWarehouse::whereHas('product', function($q) {
                $q->where('display', 1);
            })
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 10)
            ->count();

        // 4. تحديث حساب المنتجات المنتهية (Out of Stock) للمنتجات النشطة فقط
        $outOfStockCount = ProductWarehouse::whereHas('product', function($q) {
                $q->where('display', 1);
            })
            ->where('quantity', '<=', 0)
            ->count();

        $stats = [
            'total_products' => $totalProductsCount,
            'warehouses'     => $warehousesCount,
            'low_stock'      => $lowStockCount,
            'out_of_stock'   => $outOfStockCount,
        ];

        // 5. تعديل استعلام المنتجات الأساسي لإحضار النشطة فقط
        $query = Product::where('display', 1)->with(['category', 'warehouses']);

        // البحث بالاسم أو الباركود
        if ($request->filled('search_name')) {
            $searchTerm = '%' . $request->search_name . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('barcode', 'like', $searchTerm);
            });
        }

        // فلترة حسب المخزن (تأكد أن المخزن المختار نشط أيضاً)
        if ($request->filled('warehouse_id')) {
            $warehouseId = $request->warehouse_id;
            $query->whereHas('warehouses', function ($q) use ($warehouseId) {
                $q->where('warehouses.id', $warehouseId)
                  ->where('warehouses.display', 1); // اختياري لزيادة الدقة
            });
        }

        // ترتيب وترقيم
        $products = $query->orderBy('id', 'desc')->paginate(10);

        // إذا كان الطلب AJAX
        if ($request->ajax()) {
            return view('admin.stores.products_table', compact('products'))->render();
        }

        return view('admin.stores.display_products', compact('products', 'warehouses', 'stats'));
    } catch (\Exception $e) {
        return "حدث خطأ في الاستعلام: " . $e->getMessage();
    }
}

   public function destroy($id)
{
    try {
        // العثور على المنتج
        $product = DB::table('products')->where('id', $id)->first();

        if ($product) {
            // ملاحظة: قمنا بإزالة كود حذف الصورة من التخزين 
            // لأن المنتج سيبقى موجوداً في قاعدة البيانات (مخفي فقط)

            // تحديث عمود display إلى 0
            DB::table('products')
                ->where('id', $id)
                ->update(['display' => 0]);

            return redirect()->back()->with('success', 'تم إخفاء المنتج من القوائم بنجاح.');
        }

        return redirect()->back()->with('error_message', 'المنتج غير موجود.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error_message', 'فشل الإخفاء: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->back()->with('error_message', 'المنتج غير موجود.');
        }

        $categories = DB::table('categories')->get();



        $currentStock = DB::table('product_warehouse')
            ->where('product_id', $id)
            ->first();

        return view('admin.stores.edit_product', compact('product', 'categories', 'currentStock'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',

            'selling_price' => 'required|numeric',
        ]);

        try {

            $updated = DB::table('products')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'category_id' => $request->category_id,


                    'selling_price' => $request->selling_price,
                    'updated_at' => now(),
                ]);


            return redirect()->route('products.index')->with('success', 'تم تحديث بيانات المنتج بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function lowStock()
    {
        // جلب المنتجات التي كميتها 10 أو أقل
        // نستخدم معها العلاقات لجلب اسم المنتج واسم المستودع
        $lowStockProducts = ProductWarehouse::with(['product', 'warehouse'])
            ->where('quantity', '<=', 10)
            ->get();

        return view('admin.stores.low_stock', compact('lowStockProducts'));
    }
}
