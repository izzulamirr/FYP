@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Transaction</title>
</head>
<
   
    <!-- Sidebar -->
    <div class="w-64 h-screen bg-gray-800 text-white fixed top-0 left-0">
        <div class="p-5 text-center text-xl font-bold border-b border-gray-600">Smart Inventory</div>
        <nav class="mt-4">
            <ul>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('dashboard') }}" class="flex items-center"><span class="mr-3">🏠</span> Dashboard</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Transaction') }}" class="flex items-center"><span class="mr-3">💰</span> Transaction</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Inventory') }}" class="flex items-center"><span class="mr-3">📦</span> Inventory</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Supply') }}" class="flex items-center"><span class="mr-3">📊</span> Supplies</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Report') }}" class="flex items-center"><span class="mr-3">📊</span> Report</a></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-left text-white px-4 py-3 hover:bg-gray-700">
                        <span class="mr-3">🚪</span> Log Out
                    </button>
                </form>
            </ul>
        </nav>
    </div>
    <!-- Main Content -->
    <div class="ml-64 p-8 w-full">
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h1 class="mb-4 text-2xl font-bold">Transaction History</h1>
        <ul class="flex border-b">
            <li class="mr-4"><a class="text-blue-500 font-semibold pb-2 border-b-2 border-blue-500" href="#customers">Customers Receipts</a></li>
            <li><a class="text-gray-500 font-semibold hover:text-blue-500" href="#suppliers">Suppliers Invoices</a></li>
        </ul>
        <div class="mt-3 overflow-auto max-h-[4100px]">            
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Receipt #</th>
                        <th class="p-3 text-left">Sales</th>
                        <th class="p-3 text-left">Payment Method</th>
                        <th class="p-3 text-left">On Duty</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div>

</html>