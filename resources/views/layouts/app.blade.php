<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Cashier</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 h-screen bg-gray-800 text-white fixed top-0 left-0">
        <div class="p-5 text-center text-xl font-bold border-b border-gray-600">Smart Inventory</div>
        <nav class="mt-4">
            <ul>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="#" class="flex items-center"><span class="mr-3">🏠</span> Dashboard</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="#" class="flex items-center"><span class="mr-3">💰</span> Transaction</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="#" class="flex items-center"><span class="mr-3">📦</span> Inventory</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="#" class="flex items-center"><span class="mr-3">📊</span> Supplies Report</a></li>
                <li class="px-4 py-3 hover:bg-red-600 mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left text-white">
                            <span class="mr-3">🚪</span> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

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
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2">
                <h2 class="text-xl font-semibold mb-2">💰 Transactions Summary</h2>
                <p class="text-gray-600">Total Transactions: <span class="font-bold">45</span></p>
                <p class="text-gray-600">Today's Sales: <span class="font-bold">$2,150.00</span></p>
            </div>

            <!-- Product Summary -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2">
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
                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Checkout</button>
            </div>
        </div>
    </div>

</body>
</html>
