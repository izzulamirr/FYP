
@extends('layouts.app')


<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>
<div class="mt-6 bg-white p-6 shadow-lg rounded-lg">



    
    <h2 class="text-xl font-semibold mb-4">Order History</h2>
    <div class="mt-3 overflow-auto max-h-[400px]">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Order ID</th>
                    <th class="p-3 text-left">Supplier Name</th>
                    <th class="p-3 text-left">Total (RM)</th>
                    <th class="p-3 text-left">Delivery Status</th>
                    <th class="p-3 text-left">Order Date</th>
                    <th class="p-3 text-left">Order Completed Date</th>
                    <th class="p-3 text-left">Invoice Slip</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="8" class="p-3 text-center text-gray-500">No orders available.</td>
                    </tr>
                @else
                    @foreach ($orders as $order)
                        <tr>
                            <td class="p-3">{{ $order->id }}</td>
                            <td class="p-3">{{ $order->supplier_name }}</td>
                            <td class="p-3">RM {{ number_format($order->total, 2) }}</td>
                            <td class="p-3">{{ $order->delivery_status }}</td>
                            <td class="p-3">{{ $order->order_date }}</td>
                            <td class="p-3">{{ $order->completed_date ?? 'N/A' }}</td>
                            <td class="p-3">
                                @if ($order->invoice_slip)
                                    <img src="{{ asset('storage/' . $order->invoice_slip) }}" alt="Invoice Slip" class="w-16 h-16 rounded-lg">
                                @else
                                    <span class="text-gray-500">No Invoice Slip</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <a href="{{ route('orders.invoice_slip', ['id' => $order->id]) }}" 
                                   class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                                    View Order
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>