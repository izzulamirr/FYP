@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Invoice Slip for Order #{{ $order->id }}</h1>
        <p><strong>Supplier Name:</strong> {{ $order->supplier_name }}</p>
        <p><strong>Total (RM):</strong> RM {{ number_format($order->total, 2) }}</p>
        <p><strong>Delivery Status:</strong> {{ $order->delivery_status }}</p>
        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p> <!-- Add this line -->
        <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
        <p><strong>Completed Date:</strong> {{ $order->completed_date ?? 'N/A' }}</p>
        <div class="mt-4">
            @if ($order->invoice_slip)
                <img src="{{ asset('storage/' . $order->invoice_slip) }}" alt="Invoice Slip" class="w-full max-w-md rounded-lg shadow-md">
            @else
                <p class="text-gray-500">No Invoice Slip Available</p>
            @endif
        </div>
    </div>
</div>
