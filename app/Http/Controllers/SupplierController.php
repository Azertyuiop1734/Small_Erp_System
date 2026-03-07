<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
 
    public function create()
    {
        return view('admin.suppliers.add_suppliers');
    }

  
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'company_name' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

      
        DB::table('suppliers')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'balance' => $request->balance ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم إضافة المورد بنجاح!');
    }
    
public function index()
{
    $suppliers = DB::table('suppliers')->orderBy('id', 'desc')->get();
    return view('admin.suppliers.display_suppliers', compact('suppliers'));
}


public function destroy($id)
{
    DB::table('suppliers')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'تم حذف المورد بنجاح!');
}

public function edit($id)
{
    $supplier = DB::table('suppliers')->where('id', $id)->first();
    
    if (!$supplier) {
        return redirect()->route('suppliers.index')->with('error_message', 'المورد غير موجود');
    }

    return view('admin.suppliers.edit', compact('supplier'));
}


public function update(Request $request, $id)
{       
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
    ]);

    try {
        DB::table('suppliers')->where('id', $id)->update([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'balance' => $request->balance, 
            'updated_at' => now(),
        ]);

        return redirect()->route('suppliers.index')->with('success', 'تم تحديث بيانات المورد بنجاح');
    } catch (\Exception $e) {
        return redirect()->back()->with('error_message', 'حدث خطأ: ' . $e->getMessage());
    }
}
}