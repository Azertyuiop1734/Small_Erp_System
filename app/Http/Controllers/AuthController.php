<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

   
            if ($user->role->role_name == 'Admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('worker.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'البريد أو كلمة المرور غير صحيحة',
        ]);
    }

   
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
