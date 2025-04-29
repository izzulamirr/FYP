<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    
public function reportDashboard()
{
    // Fetch stocks in delivery (example: products with a status of 'in delivery')
   // $stocksInDelivery = Product::where('status', 'in delivery')->count();

    // Fetch completed transactions
   // $completedTransactions = Transaction::where('status', 'completed')->count();

    // Fetch invoices to be paid (example: transactions with a status of 'pending payment')
  //  $invoicesToBePaid = Transaction::where('status', 'pending payment')->count();

    // Fetch current revenue (sum of all transactions)
    $currentRevenue = Transaction::sum('total_price');

    // Fetch December revenue (filter by December)
    $decemberRevenue = Transaction::whereMonth('created_at', 12)->sum('total_price');

    // Fetch low stock inventory (products with quantity < 10)
    $lowStockInventory = Product::where('quantity', '<', 10)->get();

    // Fetch top-selling products (group by product and sum quantities sold)
//  $topSellingProducts = Transaction::join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
  //      ->join('products', 'transaction_products.product_id', '=', 'products.id')
    //    ->select('products.name', DB::raw('SUM(transaction_products.quantity) as total_sold'), DB::raw('SUM(transaction_products.quantity * transaction_products.price) as total_sales'))
      //  ->groupBy('products.name')
        //->orderBy('total_sold', 'desc')
       // ->take(5)
       // ->get();

    return view('System.Report.Report', compact(
    //    'stocksInDelivery',
    //    'completedTransactions',
    //    'invoicesToBePaid',
        'currentRevenue',
     //   'decemberRevenue',
     //   'lowStockInventory',
      //  'topSellingProducts'
    ));
}
}
