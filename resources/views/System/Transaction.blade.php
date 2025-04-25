@extends('layouts.app')

@section('content')
    <div class="ml-64 p-8 w-full">
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
            <h1 class="mb-4 text-2xl font-bold">Transaction History</h1>

            <!-- Buttons to toggle between Customer Receipts and Supplier Invoices -->
            <ul class="flex border-b">
                <li class="mr-4">
                    <button class="text-blue-500 font-semibold pb-2 border-b-2 border-blue-500" id="customer_receipt_button" onclick="toggleSection('customer')">Customer Receipts</button>
                </li>
                <li>
                    <button class="text-gray-500 font-semibold hover:text-blue-500" id="supplier_invoice_button" onclick="toggleSection('supplier')">Supplier Invoices</button>
                </li>
            </ul>

            <!-- Customer Receipts Section -->
            <div id="customer_receipts" class="mt-3 overflow-auto max-h-[4100px]">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Receipt #</th>
                            <th class="p-3 text-left">Sales</th>
                            <th class="p-3 text-left">Payment Method</th>
                            <th class="p-3 text-left">On Duty</th>
                            <th class="p-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->receipt_date }}</td>
                                <td>{{ $receipt->receipt_number }}</td>
                                <td>{{ $receipt->sales_person }}</td>
                                <td>{{ $receipt->payment_method }}</td>
                                <td>{{ $receipt->on_duty }}</td>
                                <td><!-- Action buttons here --></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Supplier Invoices Section -->
            <div id="supplier_invoices" class="mt-3 overflow-auto max-h-[4100px]; display: none;">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Invoice Number</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Supplier</th>
                            <th class="p-3 text-left">Amount Due</th>
                            <th class="p-3 text-left">Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->supplier_name }}</td>
                                <td>{{ $invoice->amount_due }}</td>
                                <td>{{ $invoice->payment_method }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add JavaScript to toggle sections -->
    <script>
        // Function to toggle between sections
        function toggleSection(section) {
            // Hide both sections
            document.getElementById('customer_receipts').style.display = 'none';
            document.getElementById('supplier_invoices').style.display = 'none';

            // Display the selected section
            if (section === 'customer') {
                document.getElementById('customer_receipts').style.display = 'block';
                document.getElementById('customer_receipt_button').classList.add('border-blue-500', 'text-blue-500');
                document.getElementById('supplier_invoice_button').classList.remove('border-blue-500', 'text-blue-500');
            } else if (section === 'supplier') {
                document.getElementById('supplier_invoices').style.display = 'block';
                document.getElementById('supplier_invoice_button').classList.add('border-blue-500', 'text-blue-500');
                document.getElementById('customer_receipt_button').classList.remove('border-blue-500', 'text-blue-500');
            }
        }

        // Ensure Customer Receipts are shown by default when page loads
        window.onload = function() {
            toggleSection('customer');
        };
    </script>
@endsection
