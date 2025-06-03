<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\MonthlyRevenue;
use Carbon\Carbon;

class StoreAndResetRevenue extends Command
{
    protected $signature = 'revenue:store-and-reset';
    protected $description = 'Store current month gross profit (revenue minus stock purchases) and reset for new month';

    public function handle()
    {
        $now = Carbon::create(2024, 4, 1); // For April
        $year = $now->year;
        $month = $now->month;

        // Total sales for last month
        $totalSales = Transaction::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('total_price');

        // Total stock purchases (restock orders) for last month
        $totalPurchases = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('total');

        // Gross profit = sales - purchases
        $grossProfit = $totalSales - $totalPurchases;

        // Store in monthly_revenues table
        MonthlyRevenue::updateOrCreate(
    ['year' => $year, 'month' => $month],
    [
        'revenue' => $grossProfit,
        'total_sales' => $totalSales,
        'total_cost' => $totalPurchases
    ]
);

        $this->info("Gross profit for $year-$month stored: RM$grossProfit (Sales: RM$totalSales - Purchases: RM$totalPurchases)");
    }
}