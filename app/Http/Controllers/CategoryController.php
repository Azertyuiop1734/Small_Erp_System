<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
  use App\Models\Category;
class CategoryController extends Controller
{


public function index()
{
    // جلب الأقسام التي قيمتها 1 في عمود display وترتيبها من الأحدث للأقدم
    $categories = Category::where('display', 1)
        ->orderBy('id', 'desc')
        ->get();

    return view('admin.stores.display_category', compact('categories'));
}

    // صفحة إضافة قسم جديد
    public function create()
    {
        return view('admin.stores.add_category');
    }

   public function store(Request $request)
{
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    Category::create([
        'category_name' => $request->category_name,
        'description' => $request->description,
    ]);

    return redirect()->route('categories.index')
        ->with('success', 'تم إضافة القسم بنجاح');
}

 public function destroy($id)
{
    $category = Category::findOrFail($id);

   
    // تحديث قيمة العمود display بدلاً من الحذف
    $category->update([
        'display' => 0
    ]);

    return redirect()->route('categories.index')
        ->with('success', 'تم الحدف القسم بنجاح من العرض');
}
}