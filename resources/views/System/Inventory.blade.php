@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header with Username -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Inventory Dashboard</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <div class="p-8 w-full">
        <!-- Categories -->
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg hover:bg-gray-200">
            <h2 class="text-xl font-semibold mb-4">Categories</h2>
            <div class="grid grid-cols-5 gap-4">
                @foreach(['all', 'Food', 'Hardware', 'Electronics', 'Stationery'] as $cat)
                    
                @endforeach
            </div>
        </div>

        <!-- Add Product Form -->
        <form action="{{ route('inventory.store') }}" method="POST" class="mt-4 p-4 bg-white shadow-md rounded-lg">
            @csrf
            <input type="text" name="sku" placeholder="SKU" required class="p-2 border rounded">
            <input type="text" name="name" placeholder="Name" required class="p-2 border rounded">
            <input type="number" name="quantity" placeholder="Quantity" required class="p-2 border rounded">
            <input type="number" step="0.01" name="price" placeholder="Price" required class="p-2 border rounded">
            <select name="category" required class="p-2 border rounded">
                <option value="Food">Food</option>
                <option value="Hardware">Hardware</option>
                <option value="Electronics">Electronics</option>
                <option value="Stationery">Stationery</option>
            </select>
            <input type="text" name="supplier_code" placeholder="Supplier Code" required class="p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Product</button>
        </form>

        <!-- Products Table -->
        <div class="mt-3 overflow-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Quantity Left</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Supplier Code</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    @foreach($products as $product)
                        <tr class="product-row" data-category="{{ $product->category }}">
                            <td class="p-3">{{ $product->sku }}</td>
                            <td class="p-3">{{ $product->name }}</td>
                            <td class="p-3">{{ $product->quantity }}</td>
                            <td class="p-3">{{ number_format($product->price, 2) }}</td>
                            <td class="p-3">{{ $product->category }}</td>
                            <td class="p-3">{{ $product->supplier_code }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Handle category button clicks
    document.querySelectorAll('.category-btn').forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');
            const url = new URL(window.location.href);
            url.searchParams.set('category', category);
            window.location.href = url.toString();
        });
    });
</script>
