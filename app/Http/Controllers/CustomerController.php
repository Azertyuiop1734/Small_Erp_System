<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale; // استدعاء موديل المبيعات
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of all customers.
     */
    public function index()
    {
       $customers = Customer::orderBy('created_at', 'desc')->get(); 
        
        return view('worker.display_customer', compact('customers'));
    }

    /**
     * Display the purchase history of a specific customer.
     */
    public function history($id)
    {
        // جلب الزبون مع مبيعاته مرتبة من الأحدث للأقدم
        $customer = Customer::with(['sales' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        $sales = $customer->sales;

        // تجميع الإحصائيات في مصفوفة واحدة مفهومة
        $stats = [
            'total_spent'  => $sales->sum('total_amount'),
            'total_paid'   => $sales->sum('paid_amount'),
            'total_debt'   => $sales->sum('remaining_amount'),
            'orders_count' => $sales->count(),
        ];

        return view('worker.customer_history', compact('customer', 'sales', 'stats'));
    }

    /**
     * Display detailed information about a specific sale/invoice.
     */
    public function saleDetails($id)
    {
        // جلب الفاتورة مع كافة العلاقات الضرورية دفعة واحدة (Eager Loading)
        $sale = Sale::with([
            'saleItems.product', // منتجات الفاتورة
            'customer',          // الزبون
            'user',              // الموظف البائع
            'warehouse'          // المخزن
        ])->findOrFail($id);

        return view('worker.sale_details', compact('sale'));
    }



    // هذه هي الوظيفة التي يشتكي المتصفح من عدم وجودها
    public function create()
    {
        // تأكد أن ملف الـ view موجود في هذا المسار
        return view('worker.create_customer'); 
    }

    // وظيفة حفظ البيانات عند إرسال الفورم
  public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'phone'    => 'required|string|max:20',
        'address'  => 'nullable|string',
        'balance'  => 'nullable|numeric',
        'discount' => 'nullable|numeric',
    ]);

    Customer::create($validated);

    // التوجيه لنفس الصفحة مع رسالة نجاح للعرض في SweetAlert
    return redirect()->back()->with('success', 'تم إضافة الزبون بنجاح إلى النظام');
}
// 1. عرض صفحة التعديل مع بيانات الزبون
public function edit($id)
{
    $customer = Customer::findOrFail($id);
    return view('worker.edit_customer', compact('customer'));
}

// 2. تحديث البيانات في قاعدة البيانات
public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'phone'    => 'required|string|max:20',
        'address'  => 'nullable|string',
        'balance'  => 'nullable|numeric',
        'discount' => 'nullable|numeric',
    ]);

    $customer->update($validated);

   return redirect()->route('customers.index')->with('update_success', 'Customer information has been successfully updated');
}
public function destroy($id)
{
    $customer = Customer::findOrFail($id);
    $customer->delete();

    return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
}
}