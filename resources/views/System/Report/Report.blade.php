@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Report Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Report Dashboard</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>
     <div class="space-y-4">


    <!-- Statistics Section -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Current Revenue -->
        <div class="bg-gradient-to-br from-green-500 via-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Current Revenue</h2>
            <p class="text-4xl font-bold mt-2">RM{{ number_format($currentRevenue, 2) }}</p>
        </div>

        <!-- Low Stock Count -->
        <div class="bg-gradient-to-br from-red-500 via-red-400 to-red-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Low Stock Products</h2>
            <p class="text-4xl font-bold mt-2">{{ $lowStockInventory->count() }}</p>
        </div>

        <!-- Top Selling Products Count -->
        <div class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Top Selling Products</h2>
            <p class="text-4xl font-bold mt-2">{{ $topSellingProducts->count() }}</p>
        </div>
    </div>

  <!-- Sales Summary Section -->
        <div x-data="{ open: true }" class="bg-white rounded-lg shadow">
            <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                <span class="font-semibold text-gray-700">Sales Summary</span>
                <span x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" class="p-4 border-t">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Total Sales</div>
                        <div class="text-lg font-bold text-green-600">RM{{ number_format($totalSales, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Total Transactions</div>
                        <div class="text-lg font-bold">{{ $totalTransactions }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Average Sale</div>
                        <div class="text-lg font-bold">RM{{ number_format($averageSale, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit & Loss Section -->
        <div x-data="{ open: true }" class="bg-white rounded-lg shadow">
            <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                <span class="font-semibold text-gray-700">Profit & Loss</span>
                <span x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" class="p-4 border-t">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Total Sales</div>
                        <div class="text-lg font-bold text-green-600">RM{{ number_format($totalSales, 2) }}</div>
                    </div>
                   <div>
                        <div class="text-xs text-gray-500">Stock Purchases</div>
                        <div class="text-lg font-bold text-blue-600">RM{{ number_format($stockPurchases, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Gross Profit</div>
                        <div class="text-lg font-bold text-blue-600">RM{{ number_format($grossProfit, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Top Selling Products Table (Minimizable) -->
    <div x-data="{ open: true }" class="bg-white rounded-lg shadow">
        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
    <span class="font-semibold text-gray-700">Top Selling Products</span>
    <span x-text="open ? '−' : '+'"></span>
        </button>
        <div x-show="open" class="p-4 border-t">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-900">
                        <th class="text-gray-100 p-2 text-left">Product Name</th>
                        <th class="text-gray-100 p-2 text-left">Units Sold</th>
                        <th class="text-gray-100 p-2 text-left">Total Sales (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topSellingProducts as $product)
                        <tr>
                            <td class="p-2">{{ $product['name'] }}</td>
                            <td class="p-2">{{ $product['sold'] }}</td>
                            <td class="p-2">RM{{ number_format($product['sales'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 text-center text-gray-500">No sales data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <!-- Sales by Payment Method Section -->
        <div x-data="{ open: true }" class="bg-white rounded-lg shadow">
            <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                <span class="font-semibold text-gray-700">Sales by Payment Method</span>
                <span x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" class="p-4 border-t">
                <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm">
                    <thead style="background-color: #1e293b;">
                        <tr>
                            <th class="border p-2 text-left font-semibold text-white">Payment Method</th>
                            <th class="border p-2 text-left font-semibold text-white">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesByPaymentMethod as $method => $amount)
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="border p-2 text-gray-800">{{ $method }}</td>
                                <td class="border p-2 text-gray-800">RM{{ number_format($amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php
                    $paymentLabels = $salesByPaymentMethod->keys();
                    $paymentData = $salesByPaymentMethod->values();
                @endphp
                <div class="mt-4">
                    <canvas id="paymentMethodChart" style="max-width: 100%; height: 200px;"></canvas>
                </div>
            </div>
        </div>
<!-- Financial Report Line Graph (Minimizable, same size as bar graph) -->
        <div x-data="{ open: true }" class="bg-white rounded-lg shadow">
            <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
        <span class="font-semibold text-blue-800 text-lg">Monthly Sales (Last 12 Months)</span>
        <span x-text="open ? '−' : '+'"></span>
    </button>
    <div x-show="open" class="pt-4" x-transition>
        <canvas id="financialLineChart" class="w-full h-48" style="max-width:100%;height:200px;"></canvas>
    </div>
</div>


        
        </div>
    </div>
</div>

<!-- Chart.js for Payment Method Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const paymentLabels = @json($paymentLabels);
    const paymentData = @json($paymentData);

    const ctxPayment = document.getElementById('paymentMethodChart').getContext('2d');
    new Chart(ctxPayment, {
        type: 'bar',
        data: {
            labels: paymentLabels,
            datasets: [{
                label: 'Total Sales (RM)',
                data: paymentData,
                backgroundColor: [
                    'rgba(34,197,94,0.7)',
                    'rgba(59,130,246,0.7)',
                    'rgba(244,63,94,0.7)',
                    'rgba(251,191,36,0.7)',
                    'rgba(139,92,246,0.7)'
                ],
                borderColor: [
                    'rgba(34,197,94,1)',
                    'rgba(59,130,246,1)',
                    'rgba(244,63,94,1)',
                    'rgba(251,191,36,1)',
                    'rgba(139,92,246,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
   
    const ctx = document.getElementById('financialLineChart').getContext('2d');
const financialLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!}, // <-- use days here
        datasets: [{
            label: 'Total Sales',
            data: {!! json_encode($sales) !!},
            borderColor: 'rgba(59, 130, 246, 1)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'RM ' + value;
                    }
                }
            }
        }
    }
});
</script>
