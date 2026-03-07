<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
   
        $categories = DB::table('categories')->get();
       
        $warehouses = DB::table('warehouses')->get();

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

          
                $productId = DB::table('products')->insertGetId([
                    'name' => $request->name,
                    'barcode' => $request->barcode,
                    'category_id' => $request->category_id,
                   
                    
                    'selling_price' => $request->selling_price,
                    'image' => $imagePath,
                    'minimum_stock' => $request->minimum_stock ?? 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            
                DB::table('product_warehouse')->insert([
                    'product_id' => $productId,
                    'warehouse_id' => $request->warehouse_id,
                    'quantity' => $request->initial_quantity,
                    'minimum_stock' => $request->minimum_stock ?? 5,
                    'created_at' => now(),
                    'updated_at' => now(),
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
            $warehouses = DB::table('warehouses')->get();

            $query = DB::table('products')
             
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
                ->leftJoin('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
                ->select(
                    'products.id',
                    'products.name as product_name', 
                    'products.barcode',
                    'products.image',                  
                    'products.selling_price',
                    'categories.category_name',
                    'warehouses.name as warehouse_name',
                    'product_warehouse.quantity',
                     'product_warehouse.boxes_count',
                    'product_warehouse.units_per_box',
                    'product_warehouse.warehouse_id'
                );

          
            if ($request->filled('search_name')) {
                $searchTerm = '%' . $request->search_name . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('products.name', 'like', $searchTerm)
                        ->orWhere('products.barcode', 'like', $searchTerm);
                });
            }

          
            if ($request->filled('warehouse_id')) {
                $query->where('warehouses.id', $request->warehouse_id);
            }

        
            $products = $query
                ->orderBy('products.id', 'desc')
                ->paginate(10);
            if ($request->ajax()) {
                return view('admin.stores.products_table', compact('products'))->render();
            }
            return view('admin.stores.display_products', compact('products', 'warehouses'));
        } catch (\Exception $e) {
            return "حدث خطأ في الاستعلام: " . $e->getMessage();
        }
    }
    public function destroy($id)
    {
        try {
           
            $product = DB::table('products')->where('id', $id)->first();

            if ($product) {
            
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

               
                DB::table('products')->where('id', $id)->delete();

                return redirect()->back()->with('success', 'تم حذف المنتج وكافة بياناته المخزنية بنجاح.');
            }

            return redirect()->back()->with('error_message', 'المنتج غير موجود.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'فشل الحذف: ' . $e->getMessage());
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
}
