<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * عرض قائمة الفواتير مرتبة من الأحدث للأقدم
     */
    public function index()
    {
        // جلب الفواتير مع علاقة المستخدم (البائع)
        // latest() تقوم بالترتيب حسب created_at تنازلياً
        $sales = Sale::with('user')
                    ->latest()
                    ->paginate(15); // استخدمنا paginate بدلاً من get لعرض الصفحات إذا زاد العدد

        return view('worker.display_invoices', compact('sales'));
    }

    /**
     * عرض تفاصيل فاتورة محددة
     */
    public function show($id)
    {
        /* جلب الفاتورة مع:
           1. user: البائع
           2. warehouse: المخزن
           3. items.product: تفاصيل المنتجات داخل الفاتورة
        */
        // في دالة show داخل SaleController
$sale = Sale::with(['user', 'warehouse', 'saleItems.product'])->findOrFail($id);

        return view('worker.display_details_of_invoices', compact('sale'));
    }

    /**
     * دالة إضافية (اختياري): عرض فواتير الموظف الحالي فقط
     */
    public function mySales()
    {
        $sales = Sale::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('sales.index', compact('sales'));
    }
}