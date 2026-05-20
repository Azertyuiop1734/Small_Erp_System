<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Warehouse; 
use App\Models\Warehouses;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendance;
use App\Models\Sale;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // أضفت هذا السطر لإصلاح خطأ Storage في دالة update

class UserController extends Controller
{
    public function create()
    {
        $warehouses = Warehouses::all();
        return view('admin.human_management.create', compact('warehouses'));
    }

    public function createAdmin()
    {
        return view('admin.createAdmin');
    }

    // تم الإبقاء على نسخة واحدة فقط من هذه الدالة
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'salary' => 'nullable|numeric',
            'hire_date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'age' => 'required|numeric',
            'gender' => 'required',
            'job_title' => 'required',
            'phone' => 'required'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users_images', 'public');
        }

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
            'image' => $imagePath,
            'details' => $details 
        ]);

        return redirect()->back()->with('success', 'Worker created successfully with image and details.');
    }

  public function index()
{
    $workers = User::where('display', 1) // جلب المستخدمين غير المخفيين فقط
        ->whereHas('role', function($query) {
            $query->where('role_name', '!=', 'Admin');
        })
        ->with(['warehouse' => function($query) {
            $query->where('display', 1); // اختياري: جلب بيانات المخزن فقط إذا كان نشطاً
        }])
        ->get();

    return view('admin.human_management.index', compact('workers'));
}

    public function destroy($id)
{
    $user = User::findOrFail($id);

    // تغيير حالة العرض إلى 0 بدلاً من الحذف الفيزيائي
    $user->update([
        'display' => 0
    ]);

    return redirect()->back()->with('success', 'تم إخفاء بيانات العامل بنجاح');
}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $warehouses = Warehouses::all();
        return view('admin.human_management.edit', compact('user', 'warehouses'));
    }

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

        $imagePath = $user->image; 
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('users_images', 'public');
        }

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
        $query = Attendance::with(['user.warehouse', 'user.role']);

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        return view('admin.human_management.attandancy', compact('attendances'));
    }

    public function salesInfo($id) {
        $worker = User::findOrFail($id);
        $sales = Sale::where('user_id', $id)->with('saleItems.product')->get();

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

    public function profile()
    {
        $user = Auth::user()->load(['role', 'warehouse']);
        return view('worker.profile', compact('user'));
    }

    public function edit1()
    {
        $user = Auth::user();
        return view('worker.edit_profile', compact('user'));
    }

    public function update1(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $user->image = $path;
        }

        $user->details = "Age: {$request->age}; Gender: {$request->gender}; Job: {$request->job}; Phone: {$request->phone}";
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
} // نهاية الكلاس (قوس واحد فقط)