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
    <p class="text-gray-600">Total Transactions: <span class="font-bold">{{ $totalTransactions }}</span></p>
    <p class="text-gray-600">Today's Sales: <span class="font-bold">${{ number_format($todaysSales, 2) }}</span></p>
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
            
            <div class="bg-white p-6 shadow-lg rounded-lg w-1/2">
    <h2 class="text-xl font-semibold mb-4">QR Scanner</h2>
    <div id="reader" class="w-full h-64 border rounded-md"></div>
    <p class="mt-4">Scanned Result: <span id="qrResult" class="font-bold text-green-600"></span></p>
</div>

<div>
<button id="finalizeTransaction" class="bg-green-500 text-white p-2 rounded mt-4">Finalize Transaction</button>

</div>

    <script>
    const scannedItemsTable = document.getElementById('scannedItems');
    const barcodeInput = document.getElementById('barcodeInput');


    const qrScanner = new Html5QrcodeScanner("reader", { fps: 40, 
        qrbox: { width: 300, height: 100 } // Set width to 300 and height to 100
    });
qrScanner.render(onScanSuccess);

function onScanSuccess(decodedText, decodedResult) {
    document.getElementById('qrResult').innerText = decodedText;

    // Fetch product details using the scanned QR code
    fetch(`/api/products/${decodedText}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addScannedItem(data.product);
            } else {
                alert('Product not found!');
            }
        })
        .catch(error => console.error('Error:', error));
}

barcodeInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const barcode = barcodeInput.value.trim();

        if (barcode) {
            // Fetch product details using the barcode
            fetch(`/api/products/${barcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addScannedItem(data.product);
                    } else {
                        alert('Product not found!');
                    }
                })
                .catch(error => console.error('Error:', error));

            barcodeInput.value = ''; // Clear the input field
        }
    }
});

function addScannedItem(product) {
    // Check if the product is already in the table
    const existingRow = document.querySelector(`#scannedItems tr[data-id="${product.id}"]`);
    if (existingRow) {
        // Update quantity and total price
        const qtyCell = existingRow.querySelector('.qty');
        const totalCell = existingRow.querySelector('.total');
        const newQty = parseInt(qtyCell.innerText) + 1;
        qtyCell.innerText = newQty;
        totalCell.innerText = (newQty * product.price).toFixed(2);
    } else {
        // Add a new row for the product
        const row = document.createElement('tr');
        row.setAttribute('data-id', product.id);
        row.innerHTML = `
            <td class="border p-2">${product.name}</td>
            <td class="border p-2">${product.price.toFixed(2)}</td>
            <td class="border p-2 qty">1</td>
            <td class="border p-2 total">${product.price.toFixed(2)}</td>
        `;
        scannedItemsTable.appendChild(row);
    }
}
</script>

</body>
</html>
