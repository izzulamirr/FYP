<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
});

Route::get('/Transaction', function () {
    return view('System.Transaction');
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
