@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Cashier</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <!-- Main Content -->
  <div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Cashier Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>

        <!-- Cards Section -->
    <div class="mt-6 flex gap-4">
            <!-- Transactions Summary -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2 px-4 py-3 hover:bg-gray-100">
                <h2 class="text-xl font-semibold mb-2">💰 Transactions Summary</h2>
                <p class="text-gray-600">Total Transactions: <span class="font-bold">45</span></p>
                <p class="text-gray-600">Today's Sales: <span class="font-bold">$2,150.00</span></p>
            </div>

            <!-- Product Summary -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2 px-4 py-3 hover:bg-gray-100">
                <h2 class="text-xl font-semibold mb-2">📦 Product Summary</h2>
                <p class="text-gray-600">Total Products: <span class="font-bold">320</span></p>
                <p class="text-gray-600">Low Stock: <span class="text-red-500 font-bold">12</span></p>
            </div>
        </div>

        <!-- Cashier System -->
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Scan or Enter Barcode</h2>

            <!-- Barcode Input -->
            <input type="text" id="barcodeInput" class="border p-2 w-full rounded-md" placeholder="Scan barcode here..." autofocus>

            <!-- Scanned Items -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold">Scanned Items</h3>
                <table class="w-full mt-2 border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Item</th>
                            <th class="border p-2">Price</th>
                            <th class="border p-2">Qty</th>
                            <th class="border p-2">Total</th>
                        </tr>
                    </thead>
                    <tbody id="scannedItems">
                        <!-- Scanned items will be added here dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- Total & Checkout -->
            <div class="mt-6 flex justify-between">
                <h3 class="text-xl font-semibold">Total: <span id="totalAmount">$0.00</span></h3>
                <div x-data="{ open: false, selected: '' }" class="relative inline-block">
                <button @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        Checkout
    </button>
        </div>
        </div>
    </div>

 <!-- Payment Options Popup (Modal) 
 <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h2 class="text-lg font-bold mb-3">Select Payment Method</h2>
            <ul>
                <li class="mb-2">
                    <button @click="selected = 'Cash'" class="w-full text-left px-3 py-2 border rounded hover:bg-gray-100">💵 Cash</button>
                </li>
                <li class="mb-2">
                    <button @click="selected = 'QR'" class="w-full text-left px-3 py-2 border rounded hover:bg-gray-100">📱 QR Payment</button>
                </li>
                <li>
                    <button @click="selected = 'Card'" class="w-full text-left px-3 py-2 border rounded hover:bg-gray-100">💳 Card</button>
                </li>
            </ul> -->

            <!-- Selected Payment Display -
            <div x-show="selected" class="mt-4 p-2 bg-green-100 border border-green-400 rounded-lg">
                <p class="text-green-700 font-semibold">Selected: <span x-text="selected"></span></p>
            </div>

            Buttons
            <div class="flex justify-end mt-4">
                <button @click="open = false; selected = ''" class="mr-2 px-3 py-1 border rounded hover:bg-gray-200">Cancel</button>
                <button @click="alert(`Payment method selected: ${selected}`); open = false" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Confirm</button>
            </div>
        </div>
    </div>
</div>  -->

<!-- Alpine.js Script 
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('checkout', () => ({
        open: false,
        selected: '',
        selectPayment(method) {
            this.selected = method;
            this.open = false;
            alert(`Selected Payment Method: ${method}`);
        }
    }));
});
</script> -->

</body>
</html>
