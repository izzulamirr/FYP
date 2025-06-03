@extends('layouts.app')

@section('content')
<div class="ml-64 p-3 w-full">
    <!-- Header -->
    <div class="bg-white p-5 shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-gray-800">Restock Product</h2>
        
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!-- Restock Form Section -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Restock Form -->
<form action="{{ route('orders.restock.process') }}" method="POST">
    @csrf
   <!-- Product Dropdown -->
<div class="mb-6">
    <label for="product_id" class="block text-gray-700 font-semibold mb-2">Select Product</label>
    <select name="product_id" id="product_id" required class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500">
    <option value="" disabled {{ request('product') ? '' : 'selected' }}>Select a product</option>
    @foreach ($products as $product)
        <option value="{{ $product->id }}"
            data-supplier-code="{{ $product->supplier_code }}"
            data-supplier-name="{{ $product->supplier ? $product->supplier->name : 'No supplier' }}"
            {{ request('product') == $product->id ? 'selected' : '' }}>
            {{ $product->name }}
        </option>
    @endforeach
</select>
</div>

<!-- Supplier Name (auto-filled) -->
<div class="mb-6">
    <label class="block text-gray-700 font-semibold mb-2">Supplier Name</label>
    <input type="text" id="supplier_name" class="p-3 border rounded-lg w-full bg-gray-100" readonly placeholder="Supplier will appear here">
</div>

<!-- Hidden Supplier Code -->
<input type="hidden" name="supplier_code" id="supplier_code">

    <!-- Quantity Input -->
    <div class="mb-6">
        <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantity</label>
        <input type="number" name="quantity" min='0' id="quantity" placeholder="Enter quantity" required class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
        Place Order
    </button>
</form>
    </div>
</div>

<!-- JavaScript for Dynamic Product Loading -->
<script>
function fillSupplier() {
    const productSelect = document.getElementById('product_id');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const supplierName = selectedOption.getAttribute('data-supplier-name') || '';
    const supplierCode = selectedOption.getAttribute('data-supplier-code') || '';
    document.getElementById('supplier_name').value = supplierName;
    document.getElementById('supplier_code').value = supplierCode;
}
document.getElementById('product_id').addEventListener('change', fillSupplier);
window.addEventListener('DOMContentLoaded', function() {
    fillSupplier();
});
</script>