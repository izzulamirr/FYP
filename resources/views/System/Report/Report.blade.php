@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Report Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Report Dashboard</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Section -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Current Revenue -->
        <div class="bg-gradient-to-br from-green-500 via-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Current Revenue</h2>
            <p class="text-4xl font-bold mt-2">${{ number_format($currentRevenue, 2) }}</p>
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

    <!-- Low Stock Inventory Section -->
<div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800">Low Stock Inventory</h2>
    <canvas id="lowStockChart" class="mt-4" style="max-width: 100%; height: 300px; width: 100%;"></canvas> <!-- Adjusted height -->

    <table class="w-full mt-6 border-collapse border border-gray-300 rounded-lg overflow-hidden">
        <thead style="background-color: #1e293b;">
            <tr>
                <th class="border p-4 text-left font-semibold text-white">Name</th>
                <th class="border p-4 text-left font-semibold text-white">Quantity</th>
                <th class="border p-4 text-left font-semibold text-white">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lowStockInventory as $product)
                <tr class="hover:bg-gray-100 transition duration-200">
                    <td class="border p-4 text-gray-800">{{ $product->name }}</td>
                    <td class="border p-4 text-gray-800">{{ $product->quantity }}</td>
                    <td class="border p-4">
                        @if ($product->quantity < 5)
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Low Stock</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">In Stock</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border p-4 text-center text-gray-500">No low stock products.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


    <!-- Top Selling Products Section -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800">Top Selling Products</h2>
        <table class="w-full mt-4 border-collapse border border-gray-300 rounded-lg overflow-hidden">
            <thead style="background-color: #1e293b;">
                <tr>
                    <th class="border p-4 text-left font-semibold text-white">Name</th>
                    <th class="border p-4 text-left font-semibold text-white">Sold</th>
                    <th class="border p-4 text-left font-semibold text-white">Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topSellingProducts as $product)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border p-4 text-gray-800">{{ $product->name }}</td>
                        <td class="border p-4 text-gray-800">{{ $product->sold }}</td>
                        <td class="border p-4 text-gray-800">${{ number_format($product->sales, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-4 text-center text-gray-500">No top selling products.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for the Low Stock Inventory chart
    const lowStockLabels = @json($lowStockInventory->pluck('name')); // Product names
    const lowStockData = @json($lowStockInventory->pluck('quantity')); // Quantities

    // Create the chart
    const ctx = document.getElementById('lowStockChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: lowStockLabels,
            datasets: [{
                label: 'Quantity',
                data: lowStockData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Ensure the chart respects the canvas size
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>