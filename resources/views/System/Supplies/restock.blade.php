@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Restock Product</h2>
        <p class="text-gray-600">Easily restock products by selecting a supplier and product.</p>
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
            <!-- Supplier Dropdown -->
            <div class="mb-6">
                <label for="supplier_code" class="block text-gray-700 font-semibold mb-2">Select Supplier</label>
                <select name="supplier_code" id="supplier_code" required class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Select a supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_code }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Product Dropdown -->
            <div class="mb-6">
                <label for="product_id" class="block text-gray-700 font-semibold mb-2">Select Product</label>
                <select name="product_id" id="product_id" required class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500" disabled>
                    <option value="" disabled selected>Select a product</option>
                </select>
            </div>

            <!-- Quantity Input -->
            <div class="mb-6">
                <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" required class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500">
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
    document.getElementById('supplier_code').addEventListener('change', function () {
        const supplierCode = this.value;
        const productDropdown = document.getElementById('product_id');

        // Clear the product dropdown
        productDropdown.innerHTML = '<option value="" disabled selected>Loading products...</option>';
        productDropdown.disabled = true;

        // Fetch products for the selected supplier
        fetch(`/api/suppliers/${supplierCode}/products`)
            .then(response => response.json())
            .then(data => {
                productDropdown.innerHTML = '<option value="" disabled selected>Select a product</option>';
                data.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.name;
                    productDropdown.appendChild(option);
                });
                productDropdown.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                productDropdown.innerHTML = '<option value="" disabled selected>Error loading products</option>';
            });
    });
</script>