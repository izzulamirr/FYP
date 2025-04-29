<<<<<<< HEAD
@extends('layouts.app')



=======

@extends('layouts.app')

>>>>>>> f94268b96abb02bfaf1fd5a059322493e9019696
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
<<<<<<< HEAD
    </div>

<div class="p-8">
    
    @if ($transactions->isEmpty())
        <p class="text-gray-600">No transactions available.</p>
    @else
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Order ID</th>
                    <th class="p-3 text-left">Total Price</th>
                    <th class="p-3 text-left">Payment Method</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td class="p-3">{{ $transaction->order_id }}</td>
                    <td class="p-3">${{ number_format($transaction->total_price, 2) }}</td>
                    <td class="p-3">{{ $transaction->payment_method }}</td>
                    <td class="p-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td class="p-3">
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="bg-blue-500 text-white p-2 rounded">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
=======
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Cards for Customer Receipt and Supplier Invoice -->
    <div class="flex space-x-4 mt-6">
        <button id="customerReceiptCard" class="bg-blue-500 text-white p-4 rounded-lg shadow-md w-1/2 text-center">
            Customer Receipt
        </button>
        <button id="supplierInvoiceCard" class="bg-gray-200 text-gray-800 p-4 rounded-lg shadow-md w-1/2 text-center">
            Supplier Invoice
        </button>
    </div>

    <!-- Content Section -->
    <div class="p-8">
        <!-- Customer Receipt List -->
        <div id="customerReceiptList" class="block">
            @if ($transactions->isEmpty())
                <p class="text-gray-600">No customer receipts available.</p>
            @else
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Order ID</th>
                            <th class="p-3 text-left">Total Price</th>
                            <th class="p-3 text-left">Payment Method</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td class="p-3">{{ $transaction->order_id }}</td>
                            <td class="p-3">${{ number_format($transaction->total_price, 2) }}</td>
                            <td class="p-3">{{ $transaction->payment_method }}</td>
                            <td class="p-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                            <td class="p-3">
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="bg-blue-500 text-white p-2 rounded">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Supplier Invoice List -->
        <div id="supplierInvoiceList" class="hidden">
            <p class="text-gray-600">No supplier invoices available.</p>
            <!-- Add supplier invoice table here if needed -->
        </div>
    </div>
</div>

<!-- JavaScript for Card Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const customerReceiptCard = document.getElementById('customerReceiptCard');
        const supplierInvoiceCard = document.getElementById('supplierInvoiceCard');
        const customerReceiptList = document.getElementById('customerReceiptList');
        const supplierInvoiceList = document.getElementById('supplierInvoiceList');

        // Set Customer Receipt as default
        customerReceiptCard.classList.add('bg-blue-500', 'text-white');
        supplierInvoiceCard.classList.remove('bg-blue-500', 'text-white');
        supplierInvoiceCard.classList.add('bg-gray-200', 'text-gray-800');
        customerReceiptList.classList.remove('hidden');
        supplierInvoiceList.classList.add('hidden');

        // Toggle to Customer Receipt
        customerReceiptCard.addEventListener('click', function () {
            customerReceiptCard.classList.add('bg-blue-500', 'text-white');
            supplierInvoiceCard.classList.remove('bg-blue-500', 'text-white');
            supplierInvoiceCard.classList.add('bg-gray-200', 'text-gray-800');
            customerReceiptList.classList.remove('hidden');
            supplierInvoiceList.classList.add('hidden');
        });

        // Toggle to Supplier Invoice
        supplierInvoiceCard.addEventListener('click', function () {
            supplierInvoiceCard.classList.add('bg-blue-500', 'text-white');
            customerReceiptCard.classList.remove('bg-blue-500', 'text-white');
            customerReceiptCard.classList.add('bg-gray-200', 'text-gray-800');
            supplierInvoiceList.classList.remove('hidden');
            customerReceiptList.classList.add('hidden');
        });
    });
</script>
>>>>>>> f94268b96abb02bfaf1fd5a059322493e9019696
