<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExpenseController extends Controller
{
// app/Http/Controllers/ExpenseController.php

public function index()
{
  
    $expenses = Expense::with('user.warehouse')->orderBy('expense_date', 'desc')->get();
    
    return view('admin.expense', compact('expenses'));
}

public function create()
    {
        return view('worker.create_expenses');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description'  => 'nullable|string',
        ]);

        // ربط المصروف بالعامل الحالي تلقائياً
        Expense::create([
            'title'        => $validated['title'],
            'amount'       => $validated['amount'],
            'expense_date' => $validated['expense_date'],
            'description'  => $validated['description'],
            'user_id'      => Auth::id(), // ID الموظف الذي قام بالإدخال
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }
}
