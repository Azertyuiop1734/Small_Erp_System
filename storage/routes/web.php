<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
Route::get('/', function () {
    return view('welcome');
});

//----------------------------

//Authentication Login&CreateAccount

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
// صفحات بعد تسجيل الدخول
Route::get('/admin/dashboard', function () {
    return "صفحة الادمن";
})->name('admin.dashboard');

Route::get('/worker/dashboard', function () {
    return "صفحة العامل";
})->name('worker.dashboard');



//--------------------------------------



//ادارة الموارد البشرية 

// صفحة إنشاء عامل
Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create');

// حفظ العامل
Route::post('/admin/users/store', [UserController::class, 'store'])
    ->name('users.store');
    
Route::get('/admin/dashboard', function () {
    return view('admin.index1');
})->name('admin.dashboard');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/attendance', [UserController::class, 'index1'])->name('attendance.index');
// مسار صفحة مبيعات الموظف
Route::get('/users/{id}/sales', [UserController::class, 'salesInfo'])->name('users.sales');
// مسار جلب تفاصيل الفاتورة (للسويت أليرت)
Route::get('/admin/invoices/{id}', [UserController::class, 'invoiceDetails']);
// مسار لعرض قائمة كل التقارير
Route::get('/admin/reports', [UserController::class,'index2'])->name('reports.index');
// مسار لعرض تقارير مستخدم معين فقط
Route::get('/admin/users/{id}/reports', [UserController::class, 'userReports'])->name('reports.user');
Route::delete('/reports/{id}', [UserController::class, 'destroy2'])->name('reports.destroy');


//------------------------------------


// ادارة الموردين
Route::get('/admin/suppliers/add_suppliers', [SupplierController::class, 'create'])->name('suppliers.create');
Route::post('/admin/suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
Route::get('/admin/suppliers/display', [SupplierController::class, 'index'])->name('suppliers.index');
Route::delete('/admin/suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
Route::get('/admin/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('/admin/suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');



//--------------------------------------------





//ادارة المخازن و المنتجات في النضام

// اضافة مخزن
Route::get('/admin/stores/add', [StoreController::class, 'create'])->name('stores.create');
Route::post('/admin/stores/store', [StoreController::class, 'store'])->name('stores.store');
// عرض قائمة المخازن
Route::get('/admin/stores/display', [StoreController::class, 'index'])->name('stores.index');

// حذف مخزن معين
Route::delete('/admin/stores/delete/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');

//اضافة منتج
Route::get('/admin/products/add', [ProductController::class, 'create'])->name('products.create');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
//عرض كل المنتجات في النضام
Route::get('/admin/products/display', [ProductController::class, 'index'])->name('products.index');
//حدف منتج معين
Route::get('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
//تعديل منتج معين
Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');


//-------------------------------




// مجموعة مسارات المشتريات
Route::prefix('purchases')->group(function () {
    // لعرض صفحة إضافة مشتريات جديدة
    Route::get('/admin/products/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::get('/get-product/{barcode}', [PurchaseController::class, 'getProductByBarcode']);
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/{id}', [PurchaseController::class, 'show'])->name('purchases.show');
    // لاستقبال بيانات الفورم وحفظها في قاعدة البيانات
    Route::post('/store', [PurchaseController::class, 'store'])->name('purchases.store');
    
    // (اختياري) لعرض قائمة بكل المشتريات السابقة
    Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
});



//--------------------




// مسار لوحة التحكم الإحصائية
Route::get('admin/index1', [DashboardController::class, 'index'])->name('dashboard.index');





//---------------------------------



// مسارات الأقسام
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/admin/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');