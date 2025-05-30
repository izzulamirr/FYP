@extends('layouts.app')

<div class="p-8 w-full">
    <!-- Invoice Slip Container -->
    <div id="invoice" class="bg-white p-6 shadow-lg rounded-lg max-w-lg mx-auto border border-gray-300">
        <!-- Header -->
        <div class="text-center border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Invoice Slip</h1>
            <p class="text-gray-600">Supplier Restock Invoice</p>
        </div>

        <!-- Order Details -->
        <div class="mt-4">
            <p><strong>Order ID:</strong> {{ $orders->order_id }}</p>
            <p><strong>Date:</strong> {{ $orders->order_date }}</p>
            <p><strong>Supplier:</strong> {{ $orders->supplier_name }}</p>
        </div>

        <!-- Products Table -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold border-b pb-2">Products</h2>
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">Product</th>
                        <th class="border p-2 text-left">Qty</th>
                        <th class="border p-2 text-left">Cost Price</th>
                        <th class="border p-2 text-left">Subtotal</th>
                    </tr>
                </thead>
              <tbody>
@php
    $products = json_decode($orders->products, true) ?? [];
@endphp

@foreach ($products as $product)
<tr>
    <td class="border p-2">{{ $product['name'] }}</td>
    <td class="border p-2">{{ $product['quantity'] }}</td>
    <td class="border p-2">RM{{ number_format($product['cost_price'] ?? 0, 2) }}</td>
    <td class="border p-2">RM{{ number_format(($product['cost_price'] ?? 0) * ($product['quantity'] ?? 0), 2) }}</td>
</tr>
@endforeach
</tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="mt-6 border-t pt-4">
            <p class="text-lg font-bold text-right">Total: RM{{ number_format($orders->total, 2) }}</p>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 border-t pt-4">
            <p class="text-sm text-gray-600">This is a computer-generated invoice slip.</p>
        </div>
    </div>

    <!-- Print Button -->
    <div class="text-center mt-6 no-print">
        <button onclick="printInvoice()" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
            Print Invoice
        </button>
    </div>
    
</div>

<!-- CSS for A4 Print Format -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice, #invoice * {
            visibility: visible;
        }
        #invoice {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 210mm;
            height: auto;
            margin: auto;
            padding: 20mm;
            box-shadow: none;
            border: 1px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .no-print {
            display: none;
        }
    }
</style>

<!-- JavaScript for Printing -->
<script>
    function printInvoice() {
        window.print();
    }
</script>