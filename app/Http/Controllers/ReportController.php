<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch all orders
        $orders = Order::all();

        // Revenue and inventory stats
        $currentRevenue = Transaction::sum('total_price');
        $lowStockInventory = Product::where('quantity', '<', 5)->get();

        // Top selling products from transactions (not from order_items)
        $productSales = [];
        $transactions = Transaction::all();
        foreach ($transactions as $trx) {
            $products = json_decode($trx->products, true) ?? [];
            foreach ($products as $prod) {
                $id = $prod['id'] ?? null;
                if (!$id) continue;
                if (!isset($productSales[$id])) {
                    $productSales[$id] = [
                        'name' => $prod['name'] ?? 'Unknown',
                        'sold' => 0,
                        'sales' => 0,
                    ];
                }
                $productSales[$id]['sold'] += $prod['quantity'] ?? 0;
                $productSales[$id]['sales'] += ($prod['quantity'] ?? 0) * ($prod['price'] ?? 0);
            }
        }
        // Sort and take top 5
        $topSellingProducts = collect($productSales)
            ->sortByDesc('sold')
            ->take(5);

        // Stock purchases (restock cost)
        $stockPurchases = 0;
        foreach ($orders as $order) {
            $products = json_decode($order->products, true) ?? [];
            foreach ($products as $product) {
                $stockPurchases += $product['cost_price'] * $product['quantity'];
            }
        }

        // Financial reports
        $totalSales = $currentRevenue;
        $totalTransactions = Transaction::count();
        $averageSale = $totalTransactions ? $totalSales / $totalTransactions : 0;
        $totalCOGS = $stockPurchases; // Use stock purchases as COGS
        $grossProfit = $totalSales - $stockPurchases;

        $salesByPaymentMethod = Transaction::select('payment_method', DB::raw('SUM(total_price) as total'))
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
            'recentTransactions',
            'stockPurchases'
        ));
    }
}