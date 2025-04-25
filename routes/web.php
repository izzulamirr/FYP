<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerReceiptController;
use App\Http\Controllers\SupplierInvoiceController;


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

Route::get('/', function () {
    return view('System.Homepage');
     })->name('Home');

Route::get('/Supplies', function () {
    return view('System.Supplies');
    })->name('Supply');

Route::get('/Report', function () {
    return view('System.Report');
    })->name('Report');

Route::get('/Inventory', function () {
    return view('System.Inventory');
    })->name('Inventory');

Route::get('/Transaction', function () {
    return view('System.Transaction');
    })->name('Transaction');

    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/Staff', function () {
            return view('System.Staff');
        })->name('Staff');
    });


    //camera
    Route::get('/camera', function () {
        return view('System.cameratest');
    })->name('camera');



    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
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


Route::get('/Inventory', [InventoryController::class, 'index']);
Route::post('/Inventory', [InventoryController::class, 'store'])->name('Inventory');



Route::get('/Supplies', [SuppliersController::class, 'index'])->name('Supply');




Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('Staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
});

//Products pages
Route::post('/products', [InventoryController::class, 'list'])->name('products.store');
Route::get('/products/add', [InventoryController::class, 'create'])->name('products.add');


// Customer Receipts Routes
Route::get('customer-receipts', [CustomerReceiptController::class, 'index'])->name('customer.receipts.index');
Route::get('customer-receipts/create', [CustomerReceiptController::class, 'create'])->name('customer.receipts.create');
Route::post('customer-receipts', [CustomerReceiptController::class, 'store'])->name('customer.receipts.store');

// Supplier Invoices Routes
Route::get('supplier-invoices', [SupplierInvoiceController::class, 'index'])->name('supplier.invoices.index');
Route::get('supplier-invoices/create', [SupplierInvoiceController::class, 'create'])->name('supplier.invoices.create');
Route::post('supplier-invoices', [SupplierInvoiceController::class, 'store'])->name('supplier.invoices.store');

