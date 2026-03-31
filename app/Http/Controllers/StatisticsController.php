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

        // --- 1. بيانات البطاقات (كما هي سابقاً) ---
        $salesToday = Sale::whereDate('created_at', $today)->sum('total_amount');
        $salesMonth = Sale::whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->sum('total_amount');
        $salesYear = Sale::whereYear('created_at', $thisYear)->sum('total_amount');
        $totalExpenses = Expense::whereYear('created_at', $thisYear)->sum('amount'); // المصاريف لهذه السنة فقط
        $netProfit = $salesYear - $totalExpenses;


        // --- 2. تجهيز بيانات المنحنى البياني (Chart Data) ---

        // جلب أسماء الشهور (يناير، فبراير، ...) باللغة العربية أو الإنجليزية
        $labels = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create($thisYear, $m, 1)->format('F'); // 'F' تعطي اسم الشهر كاملاً بالإنجليزية
            // لاستخدام اللغة العربية، يمكنك استخدام: $labels[] = Carbon::create($thisYear, $m, 1)->locale('ar')->translatedFormat('F');
        }

        // جلب المبيعات الشهرية للسنة الحالية
        $monthlySalesData = Sale::select(
            DB::raw('sum(total_amount) as total'),
            DB::raw('DATE_FORMAT(created_at, "%m") as month') // تجميع حسب رقم الشهر
        )
            ->whereYear('created_at', $thisYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // جلب المصاريف الشهرية للسنة الحالية
        $monthlyExpensesData = Expense::select(
            DB::raw('sum(amount) as total'),
            DB::raw('DATE_FORMAT(expense_date, "%m") as month') // تجميع حسب رقم الشهر
        )
            ->whereYear('expense_date', $thisYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ملء مصفوفات البيانات بـ 0 للشهور التي لا توجد بها بيانات
        $salesChartData = array_fill(0, 12, 0);
        $expensesChartData = array_fill(0, 12, 0);
        $profitChartData = array_fill(0, 12, 0);

        foreach ($monthlySalesData as $data) {
            $salesChartData[(int)$data->month - 1] = (float)$data->total;
        }

        foreach ($monthlyExpensesData as $data) {
            $expensesChartData[(int)$data->month - 1] = (float)$data->total;
        }

        // حساب صافي الربح لكل شهر (المبيعات - المصاريف)
        for ($i = 0; $i < 12; $i++) {
            $profitChartData[$i] = $salesChartData[$i] - $expensesChartData[$i];
        }


        // إرسال البيانات الكبيرة (Chart) بشكل JSON ليفهمها الـ JavaScript
        return view('Statistics.finance.Revenues_and_Expenses', compact(
            'salesToday',
            'salesMonth',
            'salesYear',
            'totalExpenses',
            'netProfit'
        ))->with([
            'chartLabels' => json_encode($labels),
            'chartSales' => json_encode($salesChartData),
            'chartExpenses' => json_encode($expensesChartData),
            'chartProfit' => json_encode($profitChartData),
        ]);
    }



    public function index1()
    {
        $thisYear = Carbon::now()->year;

        // --- 1. حساب المؤشرات الرئيسية (KPIs) ---

        // إجمالي عدد الفواتير (لهذه السنة)
        $totalInvoicesCount = Sale::whereYear('created_at', $thisYear)->count();

        // عدد الفواتير المدفوعة بالكامل
        $paidInvoicesCount = Sale::whereYear('created_at', $thisYear)
            ->where('status', 'paid') // نعتمد على الحقل status الذي قمنا بتحديثه سابقاً
            ->count();

        // عدد الفواتير غير المدفوعة (تشمل الجزئية وغير المدفوعة تماماً)
        $unpaidInvoicesCount = Sale::whereYear('created_at', $thisYear)
            ->whereIn('status', ['partial', 'unpaid'])
            ->count();

        // متوسط قيمة الفاتورة (Average Invoice Value)
        $averageInvoiceValue = Sale::whereYear('created_at', $thisYear)->avg('total_amount') ?? 0;

        // --- خصائص إضافية قمت بإضافتها لك ---

        // أعلى قيمة فاتورة (Highest Invoice Value)
        $highestInvoiceValue = Sale::whereYear('created_at', $thisYear)->max('total_amount') ?? 0;

        // إجمالي المبالغ المحصلة (Total Collected)
        $totalCollected = Sale::whereYear('created_at', $thisYear)->sum('paid_amount');

        // إجمالي المبالغ المتبقية (Total Remaining)
        $totalRemaining = Sale::whereYear('created_at', $thisYear)->sum('remaining_amount');

        // معدل التحصيل (Collection Rate) كنسبة مئوية
        $totalAmount = Sale::whereYear('created_at', $thisYear)->sum('total_amount');
        $collectionRate = ($totalAmount > 0) ? ($totalCollected / $totalAmount) * 100 : 0;


        // --- 2. تجهيز بيانات الرسم البياني المجوف (Doughnut Chart) ---
        // البيانات هي ببساطة الأعداد التي حسبناها
        $doughnutData = [
            'paid' => $paidInvoicesCount,
            'unpaid' => $unpaidInvoicesCount,
        ];


        // تمرير البيانات للـ View
        return view('Statistics.finance.invoices', compact(
            'totalInvoicesCount',
            'paidInvoicesCount',
            'unpaidInvoicesCount',
            'averageInvoiceValue',
            'highestInvoiceValue',
            'totalCollected',
            'totalRemaining',
            'collectionRate'
        ))->with([
            // تمرير البيانات كـ JSON للـ JavaScript
            'doughnutChartData' => json_encode($doughnutData),
        ]);
    }

    public function index2()
    {
        // 1. جلب العملاء الذين لديهم فواتير غير مدفوعة بالكامل
        // نستخدم withSum لجلب إجمالي المبالغ المتبقية لكل عميل مباشرة
        $customers = Customer::whereHas('sales', function ($query) {
            $query->where('remaining_amount', '>', 0);
        })
            ->withSum(['sales as total_debt' => function ($query) {
                $query->where('remaining_amount', '>', 0);
            }], 'remaining_amount')
            ->withCount(['sales as pending_invoices' => function ($query) {
                $query->where('remaining_amount', '>', 0);
            }])
            ->orderBy('total_debt', 'desc') // ترتيب حسب الأكثر ديوناً
            ->get();

        // 2. إحصائيات سريعة للوحة التحكم
        $totalMarketDebt = Sale::sum('remaining_amount'); // إجمالي الديون في السوق
        $debtorCustomersCount = $customers->count(); // عدد العملاء المدينين
        $averageDebtPerCustomer = ($debtorCustomersCount > 0) ? ($totalMarketDebt / $debtorCustomersCount) : 0;

        return view('Statistics.finance.customers', compact(
            'customers',
            'totalMarketDebt',
            'debtorCustomersCount',
            'averageDebtPerCustomer'
        ));
    }
    // SalesController.php

    public function index3()
    {
        // ... الكود الموجود لديك حالياً ...

        $totalOrders = Sale::count();
        $totalSales = Sale::sum('total_amount');

        // الأسطر التي قد تكون ناقصة لديك:
        $remainingTotal = Sale::sum('remaining_amount'); // حساب المبالغ المتبقية

        // حساب نسبة النمو (مثال)
        $currentMonthSales = Sale::whereMonth('sale_date', now()->month)->sum('total_amount');
        $lastMonthSales = Sale::whereMonth('sale_date', now()->subMonth()->month)->sum('total_amount');
        $growthRate = $lastMonthSales > 0 ? (($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100 : 0;

        $salesData = Sale::selectRaw('DATE(sale_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(7)
            ->get();

        $recentSales = Sale::with(['customer', 'warehouse'])->latest()->take(5)->get();

        // تأكد من إضافة 'remainingTotal' هنا في الدالة compact
        return view('Statistics.sales.general_sales', compact(
            'totalOrders',
            'totalSales',
            'remainingTotal',
            'growthRate',
            'salesData',
            'recentSales'
        ));
    }
    // StatisticsController.php


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
