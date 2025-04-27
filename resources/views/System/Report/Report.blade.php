
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
            <table class="w-full mt-2 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                 
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
                
                </tbody>
            </table>
        </div>
    </div>
</div>
