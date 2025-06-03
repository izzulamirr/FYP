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

  @section('content')
    <div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
            <h1 class="text-3xl font-bold text-gray-800">Cashier Dashboard</h1>
            <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
        </div>

        <!-- Cards Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Transactions Summary -->
             <a href="{{ route('transactions.index') }}" class="block">
            <div class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl hover:scale-105 transition-transform duration-300">
                <h2 class="text-xl font-semibold mb-2">💰 Transactions Summary</h2>
                <p class="text-lg">Today's Transactions: <span class="font-bold">{{ $todaysTransactions }}</span></p>
                <p class="text-lg">Today's Sales: <span class="font-bold">RM{{ number_format($todaysSales, 2) }}</span></p>
            </div>
            </a>

            <!-- Product Summary -->
            <a href="{{ route('inventory.index') }}" class="block">
                <div class="bg-gradient-to-br from-green-500 via-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl hover:scale-105 transition-transform duration-300">
                    <h2 class="text-xl font-semibold mb-2">📦 Product Summary</h2>
                    <p class="text-lg">Total Products: <span class="font-bold">{{ $totalProducts }}</span></p>
                    <p class="text-lg">Low Stock: <span class="text-red-500 font-bold">{{ $lowStockProducts }}</span></p>
                </div>
            </a>
        </div>

        <!-- Cashier System & QR Scanner -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Cashier System -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Scan or Enter Barcode</h2>

            @if(session('error'))
                <div class="mb-2 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="mb-2 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="flex gap-2 mb-4">
                <input type="text" id="barcodeInput" name="barcode" placeholder="Enter barcode" class="p-2 border rounded w-full" autofocus>
                <button id="barcodeSearchBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Scan</button>
            </div>
                <!-- Scanned Items -->
                <div class="mt-4">
                    <h3 class="text-lg font-semibold mb-2">Scanned Items</h3>
                    <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-3 text-left">Item</th>
                                <th class="border p-3 text-left">Price</th>
                                <th class="border p-3 text-left">Quantity</th>
                                <th class="border p-3 text-left">Total</th>
                                <th class="border p-3 text-left">Actions</th>
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

    <script src="https://unpkg.com/html5-qrcode"></script>
    <audio id="beepSound" src="/beep.mp3" preload="auto"></audio>
<script>
    const scannedItemsTable = document.querySelector('#scannedItems');
    const barcodeInput = document.getElementById('barcodeInput');
    const barcodeSearchBtn = document.getElementById('barcodeSearchBtn');

    // Add scanned item to table
    function addScannedItem(product) {
        const price = parseFloat(product.price);

        if (isNaN(price)) {
            alert('Invalid product price!');
            return;
        }

        const existingRow = scannedItemsTable.querySelector(`tr[data-id="${product.id}"]`);
        if (existingRow) {
            const qtyCell = existingRow.querySelector('.qty');
            const totalCell = existingRow.querySelector('.total');
            const newQty = Math.max(0, parseInt(qtyCell.innerText) + 1);
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
                 <td class="border p-3 actions">
        <button class="increase bg-green-500 text-white px-2 py-1 rounded mr-1">+</button>
        <button class="decrease bg-yellow-500 text-white px-2 py-1 rounded mr-1">-</button>
        <button class="remove bg-red-500 text-white px-2 py-1 rounded">Remove</button>
    </td>
            `;
            scannedItemsTable.appendChild(row);
        }
    }

    scannedItemsTable.addEventListener('click', function(e) {
    const row = e.target.closest('tr');
    if (!row) return;

    const qtyCell = row.querySelector('.qty');
    const totalCell = row.querySelector('.total');
    const price = parseFloat(row.children[1].innerText);

    if (e.target.classList.contains('increase')) {
        let qty = parseInt(qtyCell.innerText);
        qtyCell.innerText = ++qty;
        totalCell.innerText = (qty * price).toFixed(2);
    }
    if (e.target.classList.contains('decrease')) {
        let qty = parseInt(qtyCell.innerText);
        if (qty > 1) {
            qtyCell.innerText = --qty;
            totalCell.innerText = (qty * price).toFixed(2);
        }
    }
    if (e.target.classList.contains('remove')) {
        row.remove();
    }
});


    // Barcode input: Enter key
    barcodeInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchBarcode();
        }
    });

    // Barcode input: Scan button
    barcodeSearchBtn.addEventListener('click', function () {
        searchBarcode();
    });

    function searchBarcode() {
        const barcode = barcodeInput.value.trim();
        if (!barcode) return;

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

    // Finalize Transaction
    document.getElementById('finalizeTransaction').addEventListener('click', function () {
        const rows = scannedItemsTable.querySelectorAll('tr');
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

    // QR Scanner
    const qrScanner = new Html5QrcodeScanner("reader", { fps: 2, qrbox: { width: 400, height: 100 } });
    qrScanner.render(onScanSuccess);

    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('qrResult').innerText = decodedText;

        document.getElementById('beepSound').play();

        
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
</script>
</body>
</html>