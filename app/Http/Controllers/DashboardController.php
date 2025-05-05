<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model
use App\Models\Transaction; // Import the Transaction model
use App\Models\Supplier; // Import the Supplier model


class DashboardController extends Controller
{
    public function index()
{
    // Fetch total transactions
    $totalTransactions = Transaction::count();

    // Fetch total suppliers
    $totalSuppliers = Supplier::count();


    // Fetch today's sales
    $todaysSales = Transaction::whereDate('created_at', today())->sum('total_price');

    // Fetch product summary data
    $totalProducts = Product::count();
    $lowStockProducts = Product::where('quantity', '<', 10)->count();

    return view('System.Dashboard', compact('totalTransactions', 'todaysSales', 'totalProducts', 'lowStockProducts'));
}
}
