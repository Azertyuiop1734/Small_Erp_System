<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ForgotPasswordController;


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
Route::get('/admin/dashboard', function () {
    return "صفحة الادمن";
})->name('admin.dashboard');

Route::get('/worker/dashboard', function () {
    return "صفحة العامل";
})->name('worker.dashboard');
Route::get('/admin/users/createAdmin', [UserController::class, 'createAdmin'])->name('users.create');
Route::post('/create-admin', [UserController::class, 'storeAdmin'])->name('admin.store');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');



Route::get('forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('otp.send');

Route::get('verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.verify.submit');

Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('otp.reset.form');
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('otp.reset.submit');


//--------------------------------------


Route::middleware(['auth'])->group(function() {



//----------------------------
//ادارة الموارد البشرية 

Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/attendance', [UserController::class, 'index1'])->name('attendance.index');
Route::get('/users/{id}/sales', [UserController::class, 'salesInfo'])->name('users.sales');
Route::get('/admin/invoices/{id}', [UserController::class, 'invoiceDetails']);
Route::get('/admin/users/{id}/reports', [UserController::class, 'userReports'])->name('reports.user');
Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/profile/edit', [UserController::class, 'edit1'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [UserController::class, 'update1'])->name('profile.update')->middleware('auth');








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
Route::get('/admin/stores/add', [StoreController::class, 'create'])->name('stores.create');
Route::post('/admin/stores/store', [StoreController::class, 'store'])->name('stores.store');
Route::get('/admin/stores/display', [StoreController::class, 'index'])->name('stores.index');
Route::delete('/admin/stores/delete/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');
Route::get('/admin/products/add', [ProductController::class, 'create'])->name('products.create');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/admin/products/display', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/admin/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/inventory/low-stock', [ProductController::class, 'lowStock'])->name('inventory.low_stock');



//-------------------------------
//ادارة المشتريات الخاصة ب النضام

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
//الصفحة الرئيسية
Route::get('admin/index1', [DashboardController::class, 'index'])->name('dashboard.index');





//---------------------------------
//ادااة الانواع 
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/admin/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');



//------------------------------------------------
//ادارة نقاط البيع
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/product/{barcode}', [POSController::class, 'getProductByBarcode']);
    Route::post('/pos/add', [POSController::class, 'storeSale']);
    // انقل هذا السطر إلى الداخل هنا
    Route::get('/customers/search', [POSController::class, 'searchCustomers']);
    Route::get('/pos/print/{id}', [POSController::class, 'printInvoice'])->name('pos.print');




//---------------------------
//ادارة الزبائن
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{id}/history', [CustomerController::class, 'history'])->name('customers.history');
Route::get('/sales/{id}/details', [CustomerController::class, 'saleDetails'])->name('sales.details');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


//-------------------------
//ادارة المصاريف 
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

//-----------------------------------------------
//ادارة التقارير الخاصة ب العمال
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/admin/reports', [ReportController::class,'index2'])->name('reports.index');
Route::delete('/reports/{id}', [ReportController::class, 'destroy2'])->name('reports.destroy');

//-----------------
//ادارة المبيعات(عرض الفواتير )
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show');
Route::post('/sales/update-payment/{id}', [App\Http\Controllers\SaleController::class, 'updatePayment'])->name('sales.updatePayment');

//---------------------------------
//الاحصائبات
Route::get('/finance-dashboard', [App\Http\Controllers\StatisticsController::class, 'index'])->name('finance.dashboard');
Route::get('/invoice-dashboard', [App\Http\Controllers\StatisticsController::class, 'index1'])->name('invoice.dashboard');
Route::get('/late-payers', [App\Http\Controllers\StatisticsController::class, 'index2'])->name('late.payers');
Route::get('/general_sales', [App\Http\Controllers\StatisticsController::class, 'index3'])->name('late.payers');
Route::get('/product-analysis', [App\Http\Controllers\StatisticsController::class, 'index4'])->name('products.analysis');
Route::get('/customers', [App\Http\Controllers\StatisticsController::class, 'index5'])->name('customers');
});

