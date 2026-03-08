<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Warehouse; // تأكد من استدعاء موديل المخزن
use App\Models\Warehouses;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendance;
use App\Models\Sale;
use App\Models\Report;
class UserController extends Controller
{
    public function create()
    {
        // جلب جميع المخازن لعرضها في القائمة المنسدلة
        $warehouses = Warehouses::all();
        return view('admin.human_management.create', compact('warehouses'));
    }
 public function createAdmin()
    {
        // جلب جميع المخازن لعرضها في القائمة المنسدلة
       
        return view('admin.createAdmin');
    }
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'salary' => 'nullable|numeric',
        'hire_date' => 'nullable|date',
        'warehouse_id' => 'required|exists:warehouses,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من الصورة
        'age' => 'required|numeric',
        'gender' => 'required',
        'job_title' => 'required',
        'phone' => 'required'
    ]);

    // 1. التعامل مع رفع الصورة
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('users_images', 'public');
    }

    // 2. تجميع التفاصيل بالإنجليزية مفصولة بـ ;
    // الترتيب: Age; Gender; Job; Phone
    $details = "Age: {$request->age}; Gender: {$request->gender}; Job: {$request->job_title}; Phone: {$request->phone}";

    $workerRole = Role::where('role_name', 'Worker')->first();

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $workerRole->id,
        'warehouse_id' => $request->warehouse_id,
        'salary' => $request->salary,
        'hire_date' => $request->hire_date,
        'status' => 'active',
        'image' => $imagePath, // حفظ مسار الصورة
        'details' => $details  // حفظ سلسلة التفاصيل
    ]);

    return redirect()->back()->with('success', 'Worker created successfully with image and details.');
}
public function storeAdmin(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $adminRole = Role::where('role_name', 'Admin')->first();

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $adminRole->id,
        'status' => 'active'
    ]);

    return redirect()->back()->with('success', 'Admin created successfully');
}

public function index()
{
    // جلب المستخدمين الذين ليس لديهم دور Admin
    // نفترض أن اسم دور الأدمن في جدول الروار هو 'Admin'
    $workers = User::whereHas('role', function($query) {
        $query->where('role_name', '!=', 'Admin');
    })->with('warehouse')->get();

    return view('admin.human_management.index', compact('workers'));
}

// 2. حذف عامل
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'تم حذف العامل بنجاح');
}

// 3. صفحة تعديل بيانات عامل
public function edit($id)
{
    $user = User::findOrFail($id);
    $warehouses = Warehouses::all();
    return view('admin.human_management.edit', compact('user', 'warehouses'));
}

// 4. تحديث البيانات (Update)
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'salary' => 'nullable|numeric',
        'warehouse_id' => 'required|exists:warehouses,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'age' => 'required|numeric',
        'gender' => 'required',
        'job_title' => 'required',
        'phone' => 'required'
    ]);

    // 1. تحديث الصورة إذا تم رفع واحدة جديدة
    $imagePath = $user->image; 
    if ($request->hasFile('image')) {
        // اختياري: حذف الصورة القديمة من السيرفر لتوفير المساحة
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $imagePath = $request->file('image')->store('users_images', 'public');
    }

    // 2. إعادة دمج التفاصيل
    $details = "Age: {$request->age}; Gender: {$request->gender}; Job: {$request->job_title}; Phone: {$request->phone}";

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'salary' => $request->salary,
        'warehouse_id' => $request->warehouse_id,
        'hire_date' => $request->hire_date,
        'image' => $imagePath,
        'details' => $details
    ]);

    return redirect()->route('users.index')->with('success', 'Worker details updated successfully');
}







    public function index1(Request $request)
    {
        // إذا أراد المستخدم الفلترة بتاريخ معين، وإلا سيجلب كل السجلات
        $query = Attendance::with(['user.warehouse', 'user.role']);

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        return view('admin.human_management.attandancy', compact('attendances'));
    }

    

// عرض ملخص مبيعات الموظف


public function salesInfo($id) {

    $worker = User::findOrFail($id);

    $sales = Sale::where('user_id', $id)
        ->with('saleItems.product')
        ->get();

    $totalSalesCount = $sales->count();
    $totalRevenue = $sales->sum('total_amount');

    $totalProfit = 0;

    foreach($sales as $sale){
        foreach($sale->saleItems as $item){

            $costPrice = $item->product->purchase_price ?? 0;

            $totalProfit += ($item->price - $costPrice) * $item->quantity;
        }
    }

    return view('admin.human_management.sales_report',
        compact('worker','sales','totalSalesCount','totalRevenue','totalProfit')
    );
}
public function index2() {
    // We load the user, and then the warehouse BELONGING to that user
    $reports = Report::with('user.warehouse')->orderBy('report_date', 'desc')->get();
    return view('admin.human_management.reports', compact('reports'));
}
public function destroy2($id)
{
    $report = Report::findOrFail($id);
    $report->delete();

    return back()->with('success', 'Report deleted successfully.');
}
}