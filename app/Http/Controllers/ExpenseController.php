<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
// app/Http/Controllers/ExpenseController.php

public function index()
{
    // نستخدم النقاط (.) لجلب علاقة داخل علاقة
    $expenses = Expense::with('user.warehouse')->orderBy('expense_date', 'desc')->get();
    
    return view('admin.expense', compact('expenses'));
}
}
