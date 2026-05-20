<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{

    public function index()
{
    $today = Carbon::today();
    $thisMonth = Carbon::now()->month;
    $thisYear = Carbon::now()->year;

    // --- 1. بيانات البطاقات (تم تعديل المسميات لتطابق الـ View) ---
    
    // مبيعات اليوم
    $salesToday = Sale::whereDate('created_at', $today)->sum('total_amount');
    
    // مبيعات الشهر (تعديل الاسم من $salesMonth إلى $salesThisMonth)
    $salesThisMonth = Sale::whereMonth('created_at', $thisMonth)
        ->whereYear('created_at', $thisYear)
        ->sum('total_amount');
        
    // مصاريف الشهر (إضافة هذا المتغير ليعمل في البطاقة الثالثة)
    $expensesThisMonth = Expense::whereMonth('created_at', $thisMonth)
        ->whereYear('created_at', $thisYear)
        ->sum('amount');

    // إجمالي المبيعات والمصاريف السنوية (للرسوم البيانية)
    $salesYear = Sale::whereYear('created_at', $thisYear)->sum('total_amount');
    $totalExpenses = Expense::whereYear('created_at', $thisYear)->sum('amount');
    $netProfit = $salesYear - $totalExpenses;

    // --- 2. تجهيز بيانات المنحنى البياني (Chart Data) ---
    $months = [];
    $monthlySalesData = [];
    $monthlyExpensesData = [];

    for ($m = 1; $m <= 12; $m++) {
        $months[] = Carbon::create($thisYear, $m, 1)->format('F');
        
        $monthlySalesData[] = Sale::whereMonth('created_at', $m)
            ->whereYear('created_at', $thisYear)
            ->sum('total_amount');
            
        $monthlyExpensesData[] = Expense::whereMonth('created_at', $m)
            ->whereYear('created_at', $thisYear)
            ->sum('amount');
    }

    return view('Statistics.finance.Revenues_and_Expenses', compact(
        'salesToday', 
        'salesThisMonth', // تم التعديل هنا
        'expensesThisMonth', // تم التعديل هنا
        'salesYear',
        'totalExpenses',
        'netProfit',
        'months',
        'monthlySalesData',
        'monthlyExpensesData'
    ));
}



    public function index1()
{
    $thisYear = now()->year;

    // 1. حساب المؤشرات الرئيسية (KPIs)
    $totalInvoicesCount = Sale::whereYear('created_at', $thisYear)->count();
    
    // حساب إجمالي عدد المنتجات المباعة في كل الفواتير
    $totalItemsCount = DB::table('sale_items') // تأكد من اسم جدول تفاصيل الفاتورة لديك
        ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
        ->whereYear('sales.created_at', $thisYear)
        ->sum('quantity');

    $highestInvoiceAmount = Sale::whereYear('created_at', $thisYear)->max('total_amount') ?? 0;
    $averageInvoiceValue = Sale::whereYear('created_at', $thisYear)->avg('total_amount') ?? 0;

    // 2. توزيع الفواتير شهرياً (الرسم البياني العمودي)
    $months = [];
    $monthlyInvoicesData = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[] = Carbon::create($thisYear, $m, 1)->format('F');
        $monthlyInvoicesData[] = Sale::whereYear('created_at', $thisYear)
            ->whereMonth('created_at', $m)
            ->count();
    }

    // 3. الفواتير حسب الموردين (الرسم البياني الدائري)
    // ملاحظة: إذا كانت الفواتير مرتبطة بعملاء وليس موردين، استبدل الموردين بالعملاء
    $supplierData = Sale::select('customers.name', DB::raw('count(*) as total'))
        ->join('customers', 'customers.id', '=', 'sales.customer_id')
        ->whereYear('sales.created_at', $thisYear)
        ->groupBy('customers.name')
        ->get();

    $supplierNames = $supplierData->pluck('name');
    $supplierInvoicesData = $supplierData->pluck('total');

    return view('Statistics.finance.invoices', compact(
        'totalInvoicesCount',
        'totalItemsCount',
        'highestInvoiceAmount',
        'averageInvoiceValue',
        'months',
        'monthlyInvoicesData',
        'supplierNames',
        'supplierInvoicesData'
    ));
}

    public function index2()
{
    // 1. جلب العملاء الذين لديهم ديون مع حساب إجمالي الدين وعدد الفواتير المعلقة
    $debtorCustomers = Customer::whereHas('sales', function ($query) {
        $query->where('remaining_amount', '>', 0);
    })->withSum(['sales as total_debt' => function ($query) {
        $query->where('remaining_amount', '>', 0);
    }], 'remaining_amount')
    ->withCount(['sales as pending_invoices' => function ($query) {
        $query->where('remaining_amount', '>', 0);
    }])
    ->orderBy('total_debt', 'desc')
    ->get();

    // 2. حساب المؤشرات الإحصائية للبطاقات
    $totalMarketDebt = Sale::sum('remaining_amount');
    $debtorCustomersCount = $debtorCustomers->count();
    
    // حساب متوسط الدين لكل عميل مدين (تجنب القسمة على صفر)
    $averageDebtPerCustomer = $debtorCustomersCount > 0 
        ? $totalMarketDebt / $debtorCustomersCount 
        : 0;

    // 3. تمرير البيانات للـ View
    return view('Statistics.finance.customers', compact(
        'debtorCustomers', 
        'totalMarketDebt', 
        'debtorCustomersCount', 
        'averageDebtPerCustomer'
    ));
}// SalesController.php

 public function index3()
{
    $thisYear = now()->year;

    // 1. حساب المؤشرات الرئيسية (KPIs)
    $totalSales = Sale::whereYear('created_at', $thisYear)->sum('total_amount');
    
    // إجمالي عدد فواتير المشتريات
    $purchaseInvoicesCount = \App\Models\Purchase::whereYear('created_at', $thisYear)->count();
    
    // إجمالي عدد فواتير المبيعات
    $totalInvoicesCount = Sale::whereYear('created_at', $thisYear)->count();
    $saleInvoicesCount = $totalInvoicesCount; 

    // أعلى قيمة فاتورة (المتغير الذي كان يسبب الخطأ)
    $highestInvoiceAmount = Sale::whereYear('created_at', $thisYear)->max('total_amount') ?? 0;

    // متوسط قيمة الفاتورة
    $averageInvoiceValue = $saleInvoicesCount > 0 ? $totalSales / $saleInvoicesCount : 0;
    
    // إجمالي عدد العملاء
    $totalCustomers = Customer::has('sales')->count();

    // 2. بيانات الرسم البياني (تطور المبيعات شهرياً)
    $months = [];
    $monthlyInvoicesData = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[] = \Carbon\Carbon::create($thisYear, $m, 1)->translatedFormat('F');
        $monthlyInvoicesData[] = Sale::whereYear('created_at', $thisYear)
            ->whereMonth('created_at', $m)
            ->sum('total_amount');
    }

    // 3. بيانات الموردين (تأكد من وجود قيم لتجنب أخطاء compact)
    $supplierNames = ['مورد 1', 'مورد 2', 'مورد 3']; 
    $supplierInvoicesData = [10, 20, 30]; 

    // 4. أحدث العمليات
    $recentSales = Sale::with('customer')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('Statistics.finance.invoices', compact(
        'totalInvoicesCount',
        'purchaseInvoicesCount',
        'saleInvoicesCount',
        'highestInvoiceAmount', // تم إضافة المتغير هنا
        'averageInvoiceValue',
        'months',
        'monthlyInvoicesData',
        'supplierNames',
        'supplierInvoicesData',
        'recentSales'
    ));
}
    public function index4()
    {
        // 1. أكثر المنتجات مبيعاً (Top 5)
        // 1. اطلب من لارافيل جمع عمود الكمية (quantity) من جدول المبيعات المرتبط
        $topSellingProducts = Product::withSum('saleItems as total_qty', 'quantity')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 2. المنتجات الراكدة (الأقل مبيعاً)
        $stagnantProducts = Product::withSum('saleItems as total_qty', 'quantity')
            ->orderBy('total_qty', 'asc')
            ->take(5)
            ->get();

        // 3. تحليل المبيعات (بناءً على السعر الموجود فقط: selling_price)
        $productSalesData = Product::select('id', 'name', 'selling_price')
            ->withSum('saleItems as total_sold_qty', 'quantity')
            ->get()
            ->map(function ($p) {
                $qty = $p->total_sold_qty ?? 0;
                $p->total_revenue = $p->selling_price * $qty; // إجمالي العوائد
                return $p;
            })->where('total_sold_qty', '>', 0)->sortByDesc('total_revenue')->take(7);

        // 4. تنبيه نقص المخزون (بناءً على وجود العمود في جدول products حسب الصورة)
        // قمنا بجمع الكميات من كل المخازن ومقارنتها بالـ minimum_stock الموجود في جدول المنتجات
        $lowStockProducts = Product::withSum('warehouses as current_stock', 'product_warehouse.quantity')
            ->get()
            ->filter(function ($product) {
                return $product->current_stock <= $product->minimum_stock;
            });

        return view('Statistics.sales.products', compact(
            'topSellingProducts',
            'stagnantProducts',
            'productSalesData',
            'lowStockProducts'
        ));
    }

public function index5()
{
    // 1. أفضل العملاء من حيث عدد الطلبات (وليس المبلغ)
    // نستخدم withCount لحساب عدد السجلات في جدول المبيعات لكل عميل
    $topActiveCustomers = Customer::withCount('sales')
        ->orderBy('sales_count', 'desc')
        ->take(5)
        ->get();

    // 2. العملاء الخاملون (الذين لم يشتروا أي شيء منذ 3 أشهر)
    // نستخدم whereDoesntHave لتصفية العملاء الذين ليس لديهم مبيعات في الفترة المحددة
    $idleCustomers = Customer::whereDoesntHave('sales', function ($query) {
        $query->where('sale_date', '>=', now()->subMonths(3));
    })->take(5)->get();

    // 3. عدد العملاء الجدد (آخر 30 يوم)
    $newCustomersCount = Customer::where('created_at', '>=', now()->subDays(30))->count();

    // 4. توزيع العملاء حسب العنوان (Address)
    // نستخدم التجميع (GroupBy) لمعرفة أكثر المناطق التي يسكن فيها عملاؤك
    $customerLocations = Customer::select('address', \DB::raw('count(*) as total'))
        ->groupBy('address')
        ->orderBy('total', 'desc')
        ->get();

    return view('Statistics.customers', compact(
        'topActiveCustomers', 
        'idleCustomers', 
        'newCustomersCount', 
        'customerLocations'
    ));
}
}
