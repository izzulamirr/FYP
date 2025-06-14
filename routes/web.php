<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisterController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Pages
//Route::get('/', function () {
   // return view('welcome');
//});


Route::post('/admin/assign-permissions', [AdminController::class, 'assignDefaultPermissions'])->name('admin.assignPermissions');
Route::get('/staff/{id}/permissions', [StaffController::class, 'permissions'])->name('staff.permissions');
Route::put('/staff/{id}/permissions', [StaffController::class, 'updatePermissions'])->name('staff.updatePermissions');

Route::get('/', function () {
    return view('System.Homepage');
     })->name('Home');

Route::get('/Supplies', function () {
    return view('System.Supplies');
    })->name('Supply');

    Route::get('/suppliers', [SuppliersController::class, 'list'])->name('suppliers.list');


    

Route::get('register', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('register', [RegisterController::class, 'store'])
    ->middleware('guest');
  

Route::get('/Inventory', function () {
    return view('System.Inventory');
    })->name('Inventory');

    
    //Route::middleware(['auth', 'admin'])->group(function () {
    //    Route::get('/Staff', function () {
    //        return view('System.Staff');
    //    })->name('Staff');
   // });

    //camera
    Route::get('/camera', function () {
        return view('System.cameratest');
    })->name('camera');



   Route::middleware([
    'auth',
    'verified',
    ])->group(function () {
        // Dashboard route using DashboardController
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });
    
    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    });


// Logout 

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to homepage after logout
})->name('logout');











//Products pages
Route::get('/Inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/products', [InventoryController::class, 'list'])->name('products.list');
//Route::get('/products/create', [InventoryController::class, 'create'])->name('products.create');
Route::get('/products/category/{category}', [InventoryController::class, 'list'])->name('products.view');
Route::get('/products/category' , [InventoryController::class, 'list'])->name('products.catagories');

Route::get('/products/create', [InventoryController::class, 'create'])->name('products.create');
Route::post('/products/store', [InventoryController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [InventoryController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [InventoryController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [InventoryController::class, 'destroy'])->name('products.delete');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
//Route::post('/products/store', [InventoryController::class, 'store'])->name('products.store');


//scanner

Route::get('/api/products/{barcode}', [ProductController::class, 'getProductByBarcode']);
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
// Route to show a specific transaction
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
Route::post('/transactions/finalize', [TransactionController::class, 'finalize'])->name('transactions.finalize');
Route::get('/purchased/summary', [TransactionController::class, 'summary'])->name('transactions.summary');
Route::post('/transactions/confirm', [TransactionController::class, 'confirm'])->name('transactions.confirm');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Display all orders
Route::get('/orders/invoice_slip/{id}', [OrderController::class, 'showInvoice'])->name('orders.invoice_slip'); // Display invoice for a specific order
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store'); // Store a new order
Route::post('/orders/reject/{order_id}', [OrderController::class, 'reject'])->name('orders.reject');
Route::post('/orders/{order_id}/upload-invoice', [OrderController::class, 'uploadInvoice'])->name('orders.uploadInvoice');


//suppliers
Route::get('/suppliers/create', [SuppliersController::class, 'create'])->name('suppliers.create');
Route::post('/suppliers', [SuppliersController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/dashboard', [SuppliersController::class, 'dashboard'])->name('suppliers.dashboard');
Route::get('/supplies', [SuppliersController::class, 'dashboard'])->name('suppliers.index');
Route::put('/suppliers/{supplier_code}', [SuppliersController::class, 'update'])->name('suppliers.update');
Route::get('/suppliers/{supplier_code}/edit', [SuppliersController::class, 'edit'])->name('suppliers.edit');
Route::delete('/suppliers/{supplier_code}', [SuppliersController::class, 'destroy'])->name('suppliers.destroy');
Route::post('/orders/confirm/{order_id}', [OrderController::class, 'confirm'])->name('orders.confirm');


// Suppliers Dashboard
Route::get('/suppliers/dashboard', [SuppliersController::class, 'dashboard'])->name('suppliers.dashboard');
// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('supplies.index');
Route::get('/orders/restock', [OrderController::class, 'restock'])->name('orders.restock');
Route::post('/orders/restock', [OrderController::class, 'processRestock'])->name('orders.restock.process');
Route::get('/api/suppliers/{supplier_code}/products', [OrderController::class, 'getProductsBySupplier']);
Route::post('/orders/confirm/{order}', [OrderController::class, 'confirm'])->name('supplies.confirm');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/{order}/upload-invoice', [OrderController::class, 'uploadInvoice'])->name('orders.uploadInvoice');



// Staff

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
     Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
     Route::post('/staff/{id}/role', [StaffController::class, 'updateRole'])->name('staff.updateRole');
    //Route::get('/staff', [StaffController::class, 'index'])->name('Staff');
    });





// Report
//Route::get('/reports', [DashboardController::class, 'index'])->name('reports.dashboard'); // Report Dashboard

  // Report
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.dashboard');
    Route::get('/report/monthly-revenue/pdf', [\App\Http\Controllers\ReportController::class, 'exportMonthlyRevenuePdf'])->name('report.monthlyRevenuePdf');

