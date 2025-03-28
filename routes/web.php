<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SuppliersController;



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
    return redirect('/'); // Redirect to homepage after logout
})->name('logout');


Route::get('/Inventory', [InventoryController::class, 'index']);
Route::post('/Inventory', [InventoryController::class, 'store'])->name('Inventory');



Route::get('/Supplies', [SuppliersController::class, 'index'])->name('Supply');