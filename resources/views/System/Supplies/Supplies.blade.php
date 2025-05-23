@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Order History Section -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Order History</h2>

        <div class="mt-3 overflow-x-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="p-4 text-left font-semibold text-gray-100">Order ID</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Supplier Name</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Total (RM)</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Delivery Status</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Order Date</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Order Completed Date</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Purchase Order</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Actions</th>
                        <th class="p-4 text-left font-semibold text-gray-100">Upload Invoice Slip</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No orders available.</td>
                        </tr>
                    @else
                        @foreach ($orders as $order)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="p-4 border-b text-gray-800">{{ $order->order_id }}</td>
                            <td class="p-4 border-b text-gray-800">{{ $order->supplier_name }}</td>
                            <td class="p-4 border-b text-gray-800">RM {{ number_format($order->total, 2) }}</td>
                            <td class="p-4 border-b">
                                @if ($order->delivery_status === 'Delivered')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Delivered</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">{{ $order->delivery_status }}</span>
                                @endif
                            </td>
                            <td class="p-4 border-b text-gray-800">{{ $order->order_date }}</td>
                            <td class="p-4 border-b text-gray-800">{{ $order->completed_date ?? 'N/A' }}</td>
                            <td class="p-4">
                                <a href="{{ route('orders.invoice_slip', $order->order_id) }}" 
                                   class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                                    View
                                </a>
                            </td>
                            <td class="p-4 border-b">
                                <div class="flex space-x-2">
                                    @if ($order->delivery_status !== 'Delivered')
                                        <form action="{{ route('orders.confirm', $order->order_id) }}" method="POST" onsubmit="return confirm('Approve and restock this order?');">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-200">
                                                Confirm
                                            </button>
                                        </form>
                                        <form action="{{ route('orders.reject', $order->order_id) }}" method="POST" onsubmit="return confirm('Reject this order?');">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-200">
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-green-600 font-semibold text-xs">Approved</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 border-b">
                                <form action="{{ route('orders.uploadInvoice', $order->order_id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                    @csrf
                                    <input type="file" name="invoice_slip" accept="image/*,application/pdf" class="block w-full text-sm text-gray-600 mb-2">
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Upload</button>
                                </form>
                                @if($order->invoice_slip)
                                    <a href="{{ asset('storage/' . $order->invoice_slip) }}" target="_blank" class="text-blue-600 underline mt-1 block">View</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>