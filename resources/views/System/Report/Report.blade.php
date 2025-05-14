
@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header with Username -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Report Dashboard</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Revenue Section -->
    <div class="mt-6 grid grid-cols-2 gap-4">
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold">Current Revenue</h2>
            <p class="text-gray-600 text-lg font-bold">${{ number_format($currentRevenue, 2) }}</p>
        </div>
    </div>

    <!-- Low Stock Inventory -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold">Low Stock Inventory</h2>
        <canvas id="lowStockChart" class="mt-4" style="max-width: 400px; max-height: 400px; margin: 0 auto;"></canvas> <!-- Graph -->

        <table class="w-full mt-6 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Quantity</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowStockInventory as $product)
                <tr>
                    <td class="border p-2">{{ $product->name }}</td>
                    <td class="border p-2">{{ $product->quantity }}</td>
                    <td class="border p-2">
                        @if ($product->quantity < 5)
                            <span class="text-red-500 font-semibold">Low Stock</span>
                        @else
                            <span class="text-green-500 font-semibold">In Stock</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border p-2 text-center text-gray-500">No low stock products.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top Selling Products -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold">Top Selling Products</h2>
        <table class="w-full mt-2 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Sold</th>
                    <th class="border p-2">Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topSellingProducts as $product)
                    <tr>
                        <td class="border p-2">{{ $product->name }}</td>
                        <td class="border p-2">{{ $product->sold }}</td>
                        <td class="border p-2">${{ number_format($product->sales, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-2 text-center text-gray-500">No top selling products.</td>
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
        type: 'bar', // Bar chart
        data: {
            labels: lowStockLabels,
            datasets: [{
                label: 'Quantity',
                data: lowStockData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allow resizing
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
