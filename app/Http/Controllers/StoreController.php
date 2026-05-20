<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $stores = DB::table('warehouses')->orderBy('id', 'desc')->get();
        return view('admin.stores.display_stores', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.add_store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
        ]);

        DB::table('warehouses')->insert([
            'name' => $request->name,
            'location' => $request->location,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('stores.index')->with('success', 'تم إضافة المخزن بنجاح!');
    }

    // دالة عرض صفحة التعديل
    public function edit($id)
    {
        $store = DB::table('warehouses')->where('id', $id)->first();
        
        if (!$store) {
            return redirect()->route('stores.index')->with('error', 'المخزن غير موجود');
        }

        return view('admin.stores.edit_store', compact('store'));
    }

    // دالة حفظ التعديلات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:500',
        ]);

        DB::table('warehouses')->where('id', $id)->update([
            'name' => $request->name,
            'location' => $request->location,
            'updated_at' => now(),
        ]);

        return redirect()->route('stores.index')->with('success', 'تم تحديث بيانات المخزن بنجاح!');
    }

    public function destroy($id)
    {
        DB::table('warehouses')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'تم حذف المخزن بنجاح!');
    }  
}