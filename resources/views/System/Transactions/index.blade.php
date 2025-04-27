@extends('layouts.app')



<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
    </div>

<div class="p-8">
    
    @if ($transactions->isEmpty())
        <p class="text-gray-600">No transactions available.</p>
    @else
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Order ID</th>
                    <th class="p-3 text-left">Total Price</th>
                    <th class="p-3 text-left">Payment Method</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td class="p-3">{{ $transaction->order_id }}</td>
                    <td class="p-3">${{ number_format($transaction->total_price, 2) }}</td>
                    <td class="p-3">{{ $transaction->payment_method }}</td>
                    <td class="p-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td class="p-3">
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="bg-blue-500 text-white p-2 rounded">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>