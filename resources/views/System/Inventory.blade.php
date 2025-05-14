@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header with Username -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Inventory Dashboard</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Categories Section -->
    <div class="p-8 w-full">
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($categories as $index => $category)
                    <a href="{{ route('products.view', ['category' => $category]) }}" 
                       class="p-6 shadow-md rounded-lg text-center cursor-pointer transition-all duration-300 transform hover:scale-105
                       @if($index % 5 === 0) bg-red-100 hover:bg-red-200
                       @elseif($index % 5 === 1) bg-blue-100 hover:bg-blue-200
                       @elseif($index % 5 === 2) bg-green-100 hover:bg-green-200
                       @elseif($index % 5 === 3) bg-yellow-100 hover:bg-yellow-200
                       @elseif($index % 5 === 4) bg-purple-100 hover:bg-purple-200
                       @endif">
                        <h3 class="text-lg font-bold text-gray-800">{{ $category }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Product Button -->
    <div class="mt-4 flex justify-end">
        <a href="{{ route('products.create') }}" 
           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition duration-200">
            ➕ Add Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Products</h2>
        <div class="overflow-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 text-left font-semibold text-gray-700">Image</th>
                        <th class="p-4 text-center font-semibold text-gray-700">SKU</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Name</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Quantity Left</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Price</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Cost Price</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Category</th>
                        <th class="p-4 text-center font-semibold text-gray-700">Supplier Code</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <!-- Product Image -->
                            <td class="p-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="p-4 text-center text-gray-800">{{ $product->sku }}</td>
                            <td class="p-4 text-center text-gray-800">{{ $product->name }}</td>
                            <td class="p-4 text-center text-gray-800">{{ $product->quantity }}</td>
                            <td class="p-4 text-center text-gray-800">${{ number_format($product->price, 2) }}</td>
                            <td class="p-4 text-center text-gray-800">${{ number_format($product->cost_price, 2) }}</td>
                            <td class="p-4 text-center text-gray-800">{{ $product->category }}</td>
                            <td class="p-4 text-center text-gray-800">{{ $product->supplier_code }}</td>
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