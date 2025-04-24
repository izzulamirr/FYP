<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model


class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total number of products
        $totalProducts = Product::count();

        // Fetch count of low-stock products (e.g., quantity < 10)
        $lowStockProducts = Product::where('quantity', '<', 10)->count();

        // Pass the data to the dashboard view
        return view('System.Dashboard', compact('totalProducts', 'lowStockProducts'));
    }
}
