
@extends('layouts.app')


<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
            <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow container mx-auto p-8">
        <!-- Customer Receipt List -->
        @if ($transactions->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <p class="text-gray-600 text-lg">No customer receipts available.</p>
            </div>
        @else
            @foreach ($transactions->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d'); // Group by date
            }) as $date => $dailyTransactions)
                <div class="mb-8">
                    <!-- Date Header -->
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Transactions for {{ $date }}</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-4 text-left font-semibold text-gray-700">Order ID</th>
                                    <th class="p-4 text-left font-semibold text-gray-700">Total Price</th>
                                    <th class="p-4 text-left font-semibold text-gray-700">Payment Method</th>
                                    <th class="p-4 text-left font-semibold text-gray-700">Payment Time</th>
                                    <th class="p-4 text-left font-semibold text-gray-700">Date</th>
                                    <th class="p-4 text-left font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyTransactions as $transaction)
                                    <tr class="hover:bg-gray-100 transition duration-200">
                                        <td class="p-4 text-gray-800">{{ $transaction->order_id }}</td>
                                        <td class="p-4 text-gray-800">RM {{ number_format($transaction->total_price, 2) }}</td>
                                        <td class="p-4 text-gray-800">{{ $transaction->payment_method }}</td>
                                        <td class="p-4 text-gray-800">
                                            {{ $transaction->payment_time ? $transaction->payment_time->format('H:i:s') : 'N/A' }}
                                        </td>
                                        <td class="p-4 text-gray-800">{{ $transaction->created_at->format('Y-m-d') }}</td>
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
                </div>
            @endforeach
        @endif
    </div>
</div>