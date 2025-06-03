<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\MonthlyRevenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; // Add this at the top


class ReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // Only use this month's data
        $currentMonthTransactions = Transaction::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $currentMonthOrders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Revenue and inventory stats for this month
        $currentRevenue = $currentMonthTransactions->sum('total_price');
        $lowStockInventory = Product::where('quantity', '<', 10)->get();

        // Top selling products for this month
        $productSales = [];
        foreach ($currentMonthTransactions as $trx) {
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
        $topSellingProducts = collect($productSales)
            ->sortByDesc('sold')
            ->take(5);

        // Stock purchases (restock cost) for this month
        $stockPurchases = 0;
        foreach ($currentMonthOrders as $order) {
            $products = json_decode($order->products, true) ?? [];
            foreach ($products as $product) {
                $stockPurchases += ($product['cost_price'] ?? 0) * ($product['quantity'] ?? 0);
            }
        }

        // Financial reports for this month
        $totalSales = $currentRevenue;
        $totalTransactions = $currentMonthTransactions->count();
        $averageSale = $totalTransactions ? $totalSales / $totalTransactions : 0;
        $totalCOGS = $stockPurchases;
        $grossProfit = $totalSales - $stockPurchases;

        // Sales by payment method for this month
        $salesByPaymentMethod = Transaction::select('payment_method', DB::raw('SUM(total_price) as total'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        $recentTransactions = Transaction::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly gross profit (from saved table, for last month)
        $lastMonth = $now->copy()->subMonth();
        $lastGrossProfit = MonthlyRevenue::where('year', $lastMonth->year)
            ->where('month', $lastMonth->month)
            ->value('revenue');

        // Monthly sales for chart (last 12 months)
        $monthlyFinancials = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(total_price) as total_sales")
        )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->take(12)
        ->get()
        ->keyBy('month');

        $months = [];
        $days = [];
        $sales = [];
        foreach ($monthlyFinancials as $monthKey => $data) {
            $months[] = $monthKey;
            $days[] = date('F Y', strtotime($monthKey));
            $sales[] = $data->total_sales;
        }

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
            'stockPurchases',
            'months',
            'sales',
            'lastGrossProfit'
        ));
    }

    public function exportMonthlyRevenuePdf(Request $request)
{
    $monthlyRevenues = \App\Models\MonthlyRevenue::orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

    $now = \Carbon\Carbon::now();
    $year = $now->year;
    $month = $now->month;

    $transactions = \App\Models\Transaction::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->get();

    $orders = \App\Models\Order::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->get();

    $currentRevenue = $transactions->sum('total_price');
    $stockPurchases = 0;
    foreach ($orders as $order) {
        $products = json_decode($order->products, true) ?? [];
        foreach ($products as $product) {
            $stockPurchases += ($product['cost_price'] ?? 0) * ($product['quantity'] ?? 0);
        }
    }
    $grossProfit = $currentRevenue - $stockPurchases;

    $data = [
        'month' => $now->format('F Y'),
        'currentRevenue' => $currentRevenue,
        'stockPurchases' => $stockPurchases,
        'grossProfit' => $grossProfit,
        'monthlyRevenues' => $monthlyRevenues,
    ];

    $pdf = \PDF::loadView('System.Report.MonthlyRevenue', $data);
    return $pdf->download('monthly_revenue_report_'.$now->format('Y_m').'.pdf');
}
}