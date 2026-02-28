<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    // عرض صفحة الإضافة
    public function create()
    {
        return view('admin.stores.add_store');
    }

    // حفظ المخزن الجديد
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

        return redirect()->back()->with('success', 'تم إضافة المخزن بنجاح!');
    }
  // جلب وعرض قائمة المخازن
public function index()
{
    $stores = DB::table('warehouses')->orderBy('id', 'desc')->get();
    return view('admin.stores.display_stores', compact('stores'));
}

// حذف مخزن
public function destroy($id)
{
    DB::table('warehouses')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'تم حذف المخزن بنجاح!');
}  
}