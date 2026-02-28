<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // عرض كل الأقسام
    public function index()
    {
        $categories = DB::table('categories')->orderBy('id', 'desc')->get();
        return view('admin.stores.display_category', compact('categories'));
    }

    // صفحة إضافة قسم جديد
    public function create()
    {
        return view('admin.stores.add_category');
    }

    // حفظ القسم في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        DB::table('categories')->insert([
            'category_name' => $request->category_name,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')->with('success', 'تم إضافة القسم بنجاح');
    }

    // حذف القسم
    public function destroy($id)
    {
        // تأكد أولاً أن القسم لا يحتوي على منتجات (اختياري لضمان سلامة البيانات)
        $hasProducts = DB::table('products')->where('category_id', $id)->exists();
        if ($hasProducts) {
            return redirect()->back()->with('error_message', 'لا يمكن حذف هذا القسم لأنه يحتوي على منتجات مرتبطة به!');
        }

        DB::table('categories')->where('id', $id)->delete();
        return redirect()->route('categories.index')->with('success', 'تم حذف القسم بنجاح');
    }
}