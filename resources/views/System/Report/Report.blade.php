@extends('layouts.app')

@section('content')

             @php
                $paymentLabels = $salesByPaymentMethod->keys();
                $paymentData = $salesByPaymentMethod->values();
            @endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Report Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<div class="ml-64 p-3 w-full min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-5 shadow-md rounded-lg mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            Report Dashboard
        </h1>
        <div class="flex items-center gap-3">
            <span class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</span>
        </div>
    </div>

    <div class="space-y-6">


    <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Current Revenue Card as Button -->
            <a href="{{ route('report.monthlyRevenuePdf') }}" target="_blank" class="block">
                <div class="bg-gradient-to-br from-green-500 via-green-400 to-green-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 cursor-pointer flex flex-col items-center">
                    <h2 class="text-lg font-semibold mb-1">This Month's Gross Profit</h2>
                    <p class="text-4xl font-extrabold mt-2 mb-1 tracking-tight">RM{{ number_format($grossProfit, 2) }}</p>
                    <p class="text-xs mt-1 opacity-80">Click to print PDF</p>
                </div>
            </a>
            <!-- Low Stock Count -->
            <a href="{{ route('inventory.index') }}">
            <div class="bg-gradient-to-br from-red-500 via-red-400 to-red-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-95 transition-transform duration-300 flex flex-col items-center">
                <h2 class="text-lg font-semibold mb-1">Low Stock Products</h2>
                <p class="text-4xl font-extrabold mt-2 mb-1 tracking-tight">{{ $lowStockInventory->count() }}</p>
            </div>
            </a>
            <!-- Top Selling Products Count -->
            <div class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center">
                <h2 class="text-lg font-semibold mb-1">Top Selling Products</h2>
                <p class="text-4xl font-extrabold mt-2 mb-1 tracking-tight">{{ $topSellingProducts->count() }}</p>
            </div>
        </div>

<!-- Sales by Payment Method & Monthly Sales Graphs Side by Side -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Sales by Payment Method Section -->
    <div x-data="{ open: true }" class="bg-white rounded-lg shadow h-[350px] flex flex-col">
        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
            <span class="font-semibold text-gray-700">Sales by Payment Method</span>
            <span x-text="open ? '−' : '+'"></span>
        </button>
        <div x-show="open" class="flex-1 flex flex-col p-2 border-t overflow-hidden">
            <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm mb-">
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
            <div class="flex-1 flex items-end">
                <canvas id="paymentMethodChart" style="width:100%;height:115px;"></canvas>
            </div>
        </div>
    </div>
    <!-- Financial Report Line Graph (same size as Payment Method) -->
    <div x-data="{ open: true }" class="bg-white rounded-lg shadow h-[350px] flex flex-col">
        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 focus:outline-none">
            <span class="font-semibold text-blue-800 text-lg">Monthly Sales (Last 12 Months)</span>
            <span x-text="open ? '−' : '+'"></span>
        </button>
        <div x-show="open" class="flex-1 flex flex-col pt-4 px-4 border-t overflow-hidden">
            <div class="flex-1 flex items-end">
                <canvas id="financialLineChart" style="width:100%;height:300px";></canvas>
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
