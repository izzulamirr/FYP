@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Content Section -->
    <div class="p-8">
        <!-- Customer Receipt List -->
        @if ($transactions->isEmpty())
            <p class="text-gray-600">No customer receipts available.</p>
        @else
            @foreach ($transactions->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d'); // Group by date
            }) as $date => $dailyTransactions)
                <div class="mb-6">
                    <!-- Date Header -->
                    <h2 class="text-xl font-semibold mb-4">Transactions for {{ $date }}</h2>
                    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-3 text-left">Order ID</th>
                                <th class="p-3 text-left">Total Price</th>
                                <th class="p-3 text-left">Payment Method</th>
                                <th class="p-3 text-left">Payment Time</th>
                                <th class="p-3 text-left">Date</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dailyTransactions as $transaction)
                                <tr>
                                    <td class="p-3">{{ $transaction->order_id }}</td>
                                    <td class="p-3">RM {{ number_format($transaction->total_price, 2) }}</td>
                                    <td class="p-3">{{ $transaction->payment_method }}</td>
                                    <td class="p-3">
                                        {{ $transaction->payment_time ? $transaction->payment_time->format('H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="p-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="bg-blue-500 text-white p-2 rounded">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif
    </div>
</div>