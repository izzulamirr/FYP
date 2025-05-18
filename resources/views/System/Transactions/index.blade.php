@extends('layouts.app')


<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
            <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Sort & Search Bar -->
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center mt-6 mb-4 gap-4">
        <!-- Filter by Date -->
        <form method="GET" action="{{ route('transactions.index') }}" class="flex items-center gap-2">
            <label for="date" class="text-gray-700 font-medium">By date:</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="border rounded px-3 py-2" onchange="this.form.submit()" />
            @if(request('payment_method'))
                <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
            @endif
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
        </form>
        <!-- Filter by Payment Method -->
        <form method="GET" action="{{ route('transactions.index') }}" class="flex items-center gap-2">
            <label for="payment_method" class="text-gray-700 font-medium">By payment method:</label>
            <select name="payment_method" id="payment_method" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All</option>
                <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Online Banking" {{ request('payment_method') == 'Online Banking' ? 'selected' : '' }}>Online Banking</option>
                <option value="Credit Card" {{ request('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                <option value="E-Wallet" {{ request('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                {{-- Add more methods as needed --}}
            </select>
            @if(request('date'))
                <input type="hidden" name="date" value="{{ request('date') }}">
            @endif
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
        </form>
        <!-- Search Bar -->
        <form method="GET" action="{{ route('transactions.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID or Payment Method..." class="border rounded px-3 py-2" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
            @if(request('date'))
                <input type="hidden" name="date" value="{{ request('date') }}">
            @endif
            @if(request('payment_method'))
                <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
            @endif
        </form>
    </div>

    <!-- Content Section -->
    <div class="flex-grow container mx-auto p-8">
        <!-- Customer Receipt List -->
        @if ($transactions->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <p class="text-gray-600 text-lg">No customer receipts available.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead style="background-color: #1e293b;"> <!-- Change this hex to match your sidebar color -->
                        <tr>
                            <th class="p-4 text-left font-semibold text-white">Order ID</th>
                            <th class="p-4 text-left font-semibold text-white">Date</th>
                            <th class="p-4 text-left font-semibold text-white">Payment Time</th>
                            <th class="p-4 text-left font-semibold text-white">Total Sales</th>
                            <th class="p-4 text-left font-semibold text-white">Payment Method</th>
                            <th class="p-4 text-left font-semibold text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="p-4 text-gray-800">{{ $transaction->order_id }}</td>
                                <td class="p-4 text-gray-800">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td class="p-4 text-gray-800">
                                    {{ $transaction->payment_time ? $transaction->payment_time->format('H:i:s') : 'N/A' }}
                                </td>
                                <td class="p-4 text-gray-800">RM {{ number_format($transaction->total_price, 2) }}</td>
                                <td class="p-4 text-gray-800">{{ $transaction->payment_method }}</td>
                                <td class="p-4">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" 
                                       class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>