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
        <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
            <h1 class="text-3xl font-bold text-gray-800">Cashier Dashboard</h1>
            <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
        </div>

        <!-- Cards Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Transactions Summary -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-2">💰 Transactions Summary</h2>
                <p class="text-lg">Total Transactions: <span class="font-bold">{{ $totalTransactions }}</span></p>
                <p class="text-lg">Today's Sales: <span class="font-bold">${{ number_format($todaysSales, 2) }}</span></p>
            </div>

            <!-- Product Summary -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-2">📦 Product Summary</h2>
                <p class="text-lg">Total Products: <span class="font-bold">{{ $totalProducts }}</span></p>
                <p class="text-lg">Low Stock: <span class="text-red-500 font-bold">{{ $lowStockProducts }}</span></p>
            </div>
        </div>

        <!-- Cashier System & QR Scanner -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Cashier System -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-2xl font-semibold mb-4">Scan or Enter Barcode</h2>

                <!-- Barcode Input -->
                <input type="text" id="barcodeInput" class="border p-3 w-full rounded-md focus:ring-2 focus:ring-blue-500" placeholder="Scan barcode here..." autofocus>

                <!-- Scanned Items -->
                <div class="mt-4">
                    <h3 class="text-lg font-semibold mb-2">Scanned Items</h3>
                    <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-3 text-left">Item</th>
                                <th class="border p-3 text-left">Price</th>
                                <th class="border p-3 text-left">Qty</th>
                                <th class="border p-3 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody id="scannedItems">
                            <!-- Scanned items will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
                    <!-- Finalize Transaction Button -->
        <div class="mt-6 flex justify">
            <button id="finalizeTransaction" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition duration-300">
                Finalize Transaction
            </button>
        </div>
            </div>

            <!-- QR Scanner -->
            <div class="bg-white p-10 shadow-lg rounded-lg h-auto">
    <h2 class="text-2xl font-semibold mb-4">Barcode Scanner</h2>
    <div id="reader" class="w-full h-100 border rounded-md"></div> <!-- Increased height -->
    <p class="mt-4 text-lg">Scanned Result: <span id="qrResult" class="font-bold text-green-600"></span></p>
</div>

    
    </div>

    <script>
        const scannedItemsTable = document.getElementById('scannedItems');
        const barcodeInput = document.getElementById('barcodeInput');

        // Finalize Transaction
        const finalizeTransactionButton = document.getElementById('finalizeTransaction');
        finalizeTransactionButton.addEventListener('click', function () {
            const rows = document.querySelectorAll('#scannedItems tr');
            const scannedItems = [];

            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                const qty = row.querySelector('.qty').innerText;
                scannedItems.push({ id, quantity: parseInt(qty) });
            });

            const totalPrice = Array.from(rows).reduce((total, row) => {
                const totalCell = row.querySelector('.total').innerText;
                return total + parseFloat(totalCell);
            }, 0);

            fetch('/transactions/finalize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: scannedItems, total: totalPrice })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/purchased/summary';
                } else {
                    alert('Failed to finalize transaction!');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        const qrScanner = new Html5QrcodeScanner("reader", { fps: 5, qrbox: { width: 300, height: 100 } });
        qrScanner.render(onScanSuccess);

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scanned QR Code: ${decodedText}`);
            document.getElementById('qrResult').innerText = decodedText;

            fetch(`/api/products/${decodedText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                if (data.product.quantity > 0) {
                    addScannedItem(data.product);
                } else {
                    alert('Item Sold Out!');
                }
            } else {
                alert('Product not found!');
            }
        })
        .catch(error => console.error('Error fetching product:', error));
}

        barcodeInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const barcode = barcodeInput.value.trim();

                if (barcode) {
            fetch(`/api/products/${barcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.product.quantity > 0) {
                            addScannedItem(data.product);
                        } else {
                            alert('Item Sold Out!');
                        }
                    } else {
                        alert('Product not found!');
                    }
                })
                .catch(error => console.error('Error:', error));

            barcodeInput.value = '';
        }
    }
});
        function addScannedItem(product) {
    const price = parseFloat(product.price);

    if (isNaN(price)) {
        alert('Invalid product price!');
        return;
    }

    const existingRow = document.querySelector(`#scannedItems tr[data-id="${product.id}"]`);
    if (existingRow) {
        const qtyCell = existingRow.querySelector('.qty');
        const totalCell = existingRow.querySelector('.total');
        const newQty = Math.max(0, parseInt(qtyCell.innerText) + 1); // Ensure quantity doesn't go below 0
        qtyCell.innerText = newQty;
        totalCell.innerText = (newQty * price).toFixed(2);
    } else {
        const row = document.createElement('tr');
        row.setAttribute('data-id', product.id);
        row.innerHTML = `
            <td class="border p-3">${product.name}</td>
            <td class="border p-3">${price.toFixed(2)}</td>
            <td class="border p-3 qty">1</td>
            <td class="border p-3 total">${price.toFixed(2)}</td>
        `;
        scannedItemsTable.appendChild(row);
    }
}
    </script>

</body>
</html>