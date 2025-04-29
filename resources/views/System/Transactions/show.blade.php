<<<<<<< HEAD
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
=======

@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Receipt Container -->
    <div class="bg-white p-6 shadow-lg rounded-lg max-w-lg mx-auto">
        <!-- Header -->
        <div class="text-center border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Receipt</h1>
            <p class="text-gray-600">Thank you for your purchase!</p>
        </div>

        <!-- Transaction Details -->
        <div class="mt-4">
            <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
            <p><strong>Date:</strong> {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Payment Method:</strong> {{ $transaction->payment_method }}</p>
        </div>

        <!-- Products Table -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold border-b pb-2">Products</h2>
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">Product</th>
                        <th class="border p-2 text-left">Qty</th>
                        <th class="border p-2 text-left">Price</th>
                        <th class="border p-2 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($transaction->products, true) as $product)
                    <tr>
                        <td class="border p-2">{{ $product['name'] }}</td>
                        <td class="border p-2">{{ $product['quantity'] }}</td>
                        <td class="border p-2">${{ number_format($product['price'], 2) }}</td>
                        <td class="border p-2">${{ number_format($product['quantity'] * $product['price'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="mt-6 border-t pt-4">
            <p class="text-lg font-bold text-right">Total: ${{ number_format($transaction->total_price, 2) }}</p>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 border-t pt-4">
            <p class="text-sm text-gray-600">This is a computer-generated receipt.</p>
            <p class="text-sm text-gray-600">If you have any questions, contact us at support@example.com.</p>
        </div>
    </div>
</div>
>>>>>>> f94268b96abb02bfaf1fd5a059322493e9019696
