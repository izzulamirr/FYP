@extends('layouts.app')

<div class="ml-64 p-4 w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 shadow-md rounded-lg mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600 text-base mt-2 sm:mt-0">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Order History Section -->
    <div class="bg-white p-4 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Order History</h2>

        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full bg-white shadow-md rounded-lg overflow-hidden text-sm">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Order ID</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Supplier Name</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Total (RM)</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Delivery Status</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Order Date</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Order Completed Date</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Purchase Receipt</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Actions</th>
                        <th class="p-3 text-left font-semibold text-gray-100 whitespace-nowrap">Invoice Slip</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="p-3 border-b text-gray-800 whitespace-nowrap">{{ $order->order_id }}</td>
                            <td class="p-3 border-b text-gray-800 whitespace-nowrap">{{ $order->supplier_name }}</td>
                            <td class="p-3 border-b text-gray-800 whitespace-nowrap">RM {{ number_format($order->total, 2) }}</td>
                            <td class="p-3 border-b whitespace-nowrap">
                                @if ($order->delivery_status === 'Delivered')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Delivered</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">{{ $order->delivery_status }}</span>
                                @endif
                            </td>
                            <td class="p-3 border-b text-gray-800 whitespace-nowrap">{{ $order->order_date }}</td>
                            <td class="p-3 border-b text-gray-800 whitespace-nowrap">{{ $order->completed_date ?? 'N/A' }}</td>
                            <td class="p-3 border-b whitespace-nowrap">
                                <a href="{{ route('orders.invoice_slip', $order->order_id) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600 transition">
                                    View
                                </a>
                            </td>
                            <td class="p-3 border-b whitespace-nowrap">
                                <div class="flex flex-col gap-2">
                                    @if ($order->delivery_status !== 'Delivered')
                                        <form action="{{ route('orders.confirm', $order->order_id) }}" method="POST" onsubmit="return confirm('Approve and restock this order?');">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded shadow hover:bg-green-600 transition text-xs">
                                                Confirm
                                            </button>
                                        </form>
                                        <form action="{{ route('orders.reject', $order->order_id) }}" method="POST" onsubmit="return confirm('Reject this order?');">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition text-xs">
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-green-600 font-semibold text-xs">Approved</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 border-b whitespace-nowrap">
                                @if($order->invoice_slip)
                                    <a href="{{ asset('storage/' . $order->invoice_slip) }}" target="_blank" class="flex items-center justify-center text-blue-600 hover:text-blue-800">
                                        <!-- PDF icon (Heroicons outline) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                        <span class="sr-only">View Invoice</span>
                                    </a>
                                @else
                                    <form action="{{ route('orders.uploadInvoice', $order->order_id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                        @csrf
                                        <input type="file" name="invoice_slip" accept="image/*,application/pdf" class="block w-full text-xs text-gray-600 mb-1">
                                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">Upload</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No orders available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>