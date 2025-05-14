@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Restock Product</h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Restock Form -->
        <form action="{{ route('orders.restock.process') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="supplier_code" class="block text-gray-700 font-bold mb-2">Select Supplier</label>
                <select name="supplier_code" id="supplier_code" required class="p-2 border rounded w-full">
                    <option value="" disabled selected>Select a supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_code }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="product_id" class="block text-gray-700 font-bold mb-2">Select Product</label>
                <select name="product_id" id="product_id" required class="p-2 border rounded w-full" enable>
                    <option value="" enable selected>Select a product</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" required class="p-2 border rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Place Order</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('supplier_code').addEventListener('change', function () {
         const supplierCode = this.value; // Ensure this is the correct value
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