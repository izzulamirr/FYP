@extends('layouts.app')

<div class="p-8 w-full">
    <!-- Receipt Container -->
    <div id="receipt" class="bg-white p-6 shadow-lg rounded-lg max-w-lg mx-auto border border-gray-300">
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
                        <td class="border p-2">RM{{ number_format($product['price'], 2) }}</td>
                        <td class="border p-2">RM{{ number_format($product['quantity'] * $product['price'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="mt-6 border-t pt-4">
            <p class="text-lg font-bold text-right">Total: RM{{ number_format($transaction->total_price, 2) }}</p>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 border-t pt-4">
            <p class="text-sm text-gray-600">This is a computer-generated receipt.</p>
            <p class="text-sm text-gray-600">If you have any questions, contact us at support@example.com.</p>
        </div>
    </div>

    <!-- Print Button -->
    <div class="text-center mt-6 no-print">
        <button onclick="printReceipt()" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
            Print Receipt
        </button>
    </div>
</div>

<!-- CSS for A4 Print Format -->
<style>
    @media print {
        /* Hide everything except the receipt */
        body * {
            visibility: hidden;
        }

        #receipt, #receipt * {
            visibility: visible;
        }

        #receipt {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center horizontally and vertically */
            width: 210mm; /* A4 width */
            height: auto; /* Allow content to determine height */
            margin: auto;
            padding: 20mm;
            box-shadow: none;
            border: 1px solid black; /* Add visible outline */
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
            display: none; /* Hide elements like buttons during printing */
        }
    }
</style>

<!-- JavaScript for Printing -->
<script>
    function printReceipt() {
        window.print();
    }
</script>