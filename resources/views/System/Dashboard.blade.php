@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Cashier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
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
            <p class="text-gray-600">Total Products: <span class="font-bold">{{ $totalProducts }}</span></p>
            <p class="text-gray-600">Low Stock: <span class="text-red-500 font-bold">{{ $lowStockProducts }}</span></p>
        </div>
    </div>

        <!-- Cashier System & QR Scanner -->
        <div class="mt-6 flex gap-4">
            <!-- Cashier System -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2">
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
            </div>
            
            <!-- QR Scanner -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2">
                <h2 class="text-xl font-semibold mb-4"> Scanner</h2>
                <div id="reader" class="w-full h-64 border rounded-md"></div>
                <p class="mt-4">Scanned Result: <span id="qrResult" class="font-bold text-green-600"></span></p>
            </div>
        </div>
    </div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qrResult').innerText = decodedText;
        }

        let scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        scanner.render(onScanSuccess);
    </script>

</body>
</html>
