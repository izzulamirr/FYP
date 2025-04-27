@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Transactions History:</h1>
    </div>

<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Transaction Details</h1>
    <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
    <p><strong>Total Price:</strong> ${{ number_format($transaction->total_price, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ $transaction->payment_method }}</p>
    <p><strong>Date:</strong> {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>

    <h2 class="text-xl font-semibold mt-6">Products</h2>
    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden mt-4">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Product</th>
                <th class="p-3 text-left">Quantity</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach (json_decode($transaction->products, true) as $product)
            <tr>
                <td class="p-3">{{ $product['name'] }}</td>
                <td class="p-3">{{ $product['quantity'] }}</td>
                <td class="p-3">${{ number_format($product['price'], 2) }}</td>
                <td class="p-3">${{ number_format($product['quantity'] * $product['price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
