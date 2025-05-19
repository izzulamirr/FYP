<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class ReportController extends Controller
{


  public function index()
{
    $currentRevenue = Transaction::sum('total_price');
    $lowStockInventory = Product::where('quantity', '<', 5)->get();
    $topSellingProducts = Product::withCount(['orderItems as sold' => function($q) {
        $q->select(\DB::raw("SUM(quantity)"));
    }])->orderByDesc('sold')->take(5)->get()->map(function($product) {
        $product->sales = $product->sold * $product->price;
        return $product;
    });

    // Financial reports
    $totalSales = $currentRevenue;
    $totalTransactions = Transaction::count();
    $averageSale = $totalTransactions ? $totalSales / $totalTransactions : 0;
    $totalCOGS = Transaction::sum(\DB::raw('quantity * (SELECT cost_price FROM products WHERE products.id = JSON_EXTRACT(transactions.products, "$[0].id"))')); // Simplified, adjust as needed
    $grossProfit = $totalSales - $totalCOGS;

    $salesByPaymentMethod = Transaction::select('payment_method', \DB::raw('SUM(total_price) as total'))
        ->groupBy('payment_method')
        ->pluck('total', 'payment_method');

    $recentTransactions = Transaction::orderBy('created_at', 'desc')->take(10)->get();

    return view('System.Report.Report', compact(
        'currentRevenue',
        'lowStockInventory',
        'topSellingProducts',
        'totalSales',
        'totalTransactions',
        'averageSale',
        'totalCOGS',
        'grossProfit',
        'salesByPaymentMethod',
        'recentTransactions'
    ));
}
}
