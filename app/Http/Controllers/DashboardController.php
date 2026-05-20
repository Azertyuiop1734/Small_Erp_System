<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\ProductWarehouse;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * لوحة تحكم الأدمن (الإحصائيات العامة)
     */
    public function index()
    {
        $totalPurchases = Purchase::sum('total_amount') ?? 0;
        $totalSales = Sale::sum('total_amount') ?? 0;

        $grossProfit = $totalSales - $totalPurchases;
        $invoiceCount = Sale::count();
        $productCount = ProductWarehouse::sum('quantity') ?? 0;
        $employeeCount = User::count();

        $monthlyProfit = Sale::select(
            DB::raw('SUM(total_amount) as revenue'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month") // تم تعديل sale_date إلى created_at لضمان التوافق
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.index1', compact(
            'totalSales',
            'grossProfit',
            'invoiceCount',
            'productCount',
            'employeeCount',
            'monthlyProfit'
        ));
    }

    /**
     * لوحة تحكم الموظف (إحصائيات شخصية فقط)
     */
    public function workerIndex()
    {
        $userId = auth()->id();

        // تجميع بيانات الموظف الحالي فقط
        $data = [
            'todaySales' => Sale::where('user_id', $userId)->whereDate('created_at', now())->count(),
            'completedInvoices' => Sale::where('user_id', $userId)->where('status', 'paid')->count(),
            'pendingOrders' => Sale::where('user_id', $userId)->where('status', 'pending')->count(),
            'totalCommission' => Sale::where('user_id', $userId)->sum('total_amount') * 0.02, // عمولة افتراضية 2%
            'recentSales' => Sale::where('user_id', $userId)->latest()->take(5)->get(),
        ];

        return view('worker.worker_dashboard', $data);
    }
}