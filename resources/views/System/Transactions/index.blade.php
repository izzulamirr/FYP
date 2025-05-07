@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Tabs for Customer Receipt and Supplier Invoice -->
    <div class="flex space-x-4 mt-6">
        <button id="customerReceiptTab" class="bg-blue-500 text-white p-4 rounded-lg shadow-md w-1/2 text-center">
            Customer Receipt
        </button>
        <button id="supplierInvoiceTab" class="bg-gray-200 text-gray-800 p-4 rounded-lg shadow-md w-1/2 text-center">
            Supplier Invoice
        </button>
    </div>

    <!-- Content Section -->
    <div class="p-8">
        <!-- Customer Receipt Table -->
        <div id="customerReceiptSection" class="block">
            <h2 class="text-xl font-semibold mb-4">Customer Receipt</h2>
            @if ($transactions->isEmpty())
                <p class="text-gray-600">No customer receipts available.</p>
            @else
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Transaction ID</th>
                            <th class="p-3 text-left">Order ID</th>
                            <th class="p-3 text-left">Total Price (RM)</th>
                            <th class="p-3 text-left">Payment Method</th>
                            <th class="p-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="p-3">{{ $transaction->id }}</td>
                                <td class="p-3">{{ $transaction->order_id }}</td>
                                <td class="p-3">RM {{ number_format($transaction->total_price, 2) }}</td>
                                <td class="p-3">{{ $transaction->payment_method }}</td>
                                <td class="p-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Supplier Invoice Table -->
        <div id="supplierInvoiceSection" class="hidden">
            <h2 class="text-xl font-semibold mb-4">Supplier Invoice</h2>
            @if ($orders->isEmpty())
                <p class="text-gray-600">No supplier invoices available.</p>
            @else
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
                                    <a href="{{ route('transactions.supplier-invoice', ['id' => $order->id]) }}" 
                                       class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript for Tab Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const customerReceiptTab = document.getElementById('customerReceiptTab');
        const supplierInvoiceTab = document.getElementById('supplierInvoiceTab');
        const customerReceiptSection = document.getElementById('customerReceiptSection');
        const supplierInvoiceSection = document.getElementById('supplierInvoiceSection');

        // Event listener for Customer Receipt Tab
        customerReceiptTab.addEventListener('click', function () {
            customerReceiptSection.classList.remove('hidden');
            supplierInvoiceSection.classList.add('hidden');
            customerReceiptTab.classList.add('bg-blue-500', 'text-white');
            customerReceiptTab.classList.remove('bg-gray-200', 'text-gray-800');
            supplierInvoiceTab.classList.add('bg-gray-200', 'text-gray-800');
            supplierInvoiceTab.classList.remove('bg-blue-500', 'text-white');
        });

        // Event listener for Supplier Invoice Tab
        supplierInvoiceTab.addEventListener('click', function () {
            supplierInvoiceSection.classList.remove('hidden');
            customerReceiptSection.classList.add('hidden');
            supplierInvoiceTab.classList.add('bg-blue-500', 'text-white');
            supplierInvoiceTab.classList.remove('bg-gray-200', 'text-gray-800');
            customerReceiptTab.classList.add('bg-gray-200', 'text-gray-800');
            customerReceiptTab.classList.remove('bg-blue-500', 'text-white');
        });
    });
</script>