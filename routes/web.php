<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
use App\Http\Controllers\UserController;
// صفحات بعد تسجيل الدخول
Route::get('/admin/dashboard', function () {
    return "صفحة الادمن";
})->name('admin.dashboard');

Route::get('/worker/dashboard', function () {
    return "صفحة العامل";
})->name('worker.dashboard');


// صفحة إنشاء عامل
Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create');

// حفظ العامل
Route::post('/admin/users/store', [UserController::class, 'store'])
    ->name('users.store');
    
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

 


