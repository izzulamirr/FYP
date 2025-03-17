<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;


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
Route::get('/', function () {
    return view('welcome');
});

Route::get('/Homepage', function () {
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('System.Dashboard');
    })->name('dashboard');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Logout 

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/Homepage'); // Redirect to homepage after logout
})->name('logout');



// Inventory routes
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
