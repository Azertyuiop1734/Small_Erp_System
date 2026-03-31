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
public function updatePayment(Request $request, $id)
{
    // 1. جلب الفاتورة
    $sale = \App\Models\Sale::findOrFail($id);

    // 2. التحقق من القيمة المرسلة
    $request->validate([
        'paid_amount' => 'required|numeric|min:0',
    ]);

    $paid = (float) $request->paid_amount;
    $total = (float) $sale->total_amount;
    $remaining = $total - $paid;

    // 3. التحديث الفعلي في قاعدة البيانات
    $sale->update([
        'paid_amount' => $paid,
        'remaining_amount' => $remaining,
        'status' => ($remaining <= 0) ? 'paid' : ($remaining < $total ? 'partial' : 'unpaid')
    ]);

    // 4. العودة للخلف مع رسالة نجاح
    return back()->with('success', 'Invoice #' . $id . ' updated successfully!');
}
}
