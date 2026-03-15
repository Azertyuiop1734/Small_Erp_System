<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
  use App\Models\Category;
class CategoryController extends Controller
{


public function index()
{
    $categories = Category::orderBy('id', 'desc')->get();
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

    if ($category->products()->exists()) {
        return redirect()->back()
            ->with('error_message', 'لا يمكن حذف هذا القسم لأنه يحتوي على منتجات مرتبطة به!');
    }

    $category->delete();

    return redirect()->route('categories.index')
        ->with('success', 'تم حذف القسم بنجاح');
}
}