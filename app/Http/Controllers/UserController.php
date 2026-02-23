<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض صفحة إنشاء عامل
    public function create()
    {
        return view('admin.users.create');
    }

    // حفظ العامل في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'salary' => 'nullable|numeric',
            'hire_date' => 'nullable|date'
        ]);

        // جلب role الخاص بـ Worker
        $workerRole = Role::where('role_name', 'Worker')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $workerRole->id,
            'salary' => $request->salary,
            'hire_date' => $request->hire_date,
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'تم إنشاء العامل بنجاح');
    }
}

