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
            DB::raw("DATE_FORMAT(sale_date, '%Y-%m') as month")
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
}
