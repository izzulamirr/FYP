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
        // Fetch current revenue
        $currentRevenue = Transaction::sum('total_price');

        // Fetch low stock inventory (products with quantity < 10)
        $lowStockInventory = Product::where('quantity', '<', 10)->get();

        $topSellingProducts = DB::table('order_items')
    ->join('products', 'order_items.product_id', '=', 'products.id')
    ->select('products.name')
    ->selectRaw('SUM(order_items.quantity) as total_sold')
    ->groupBy('products.name')
    ->orderByDesc('total_sold')
    ->take(5) // Limit to top 5 products
    ->get();


        // Pass the data to the view
        return view('System.Report.Report', compact('currentRevenue', 'lowStockInventory' , 'topSellingProducts'));
    }

}
