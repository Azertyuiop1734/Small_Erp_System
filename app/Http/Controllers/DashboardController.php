<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
  
        $totalSales = DB::table('sales')->sum('total_amount') ?? 0;
    
       
        $totalPurchases = DB::table('purchases')->sum('total_amount') ?? 0;

        $grossProfit = $totalSales - $totalPurchases;

    
        $invoiceCount = DB::table('sales')->count();

  
        $productCount = DB::table('product_warehouse')->sum('quantity') ?? 0;

        $employeeCount = DB::table('users')->count();

        $monthlyProfit = DB::table('sales')
            ->select(
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw("DATE_FORMAT(sale_date, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.index1', compact(
            'totalSales', 'grossProfit', 'invoiceCount', 
            'productCount', 'employeeCount', 'monthlyProfit'
        ));
    }
}