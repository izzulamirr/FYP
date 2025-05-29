@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Products in Category: {{ $category }}</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Categories Dropdown -->
    <div class="mt-6 bg-white p-6 shadow-md rounded-lg">
        <form action="{{ route('products.list') }}" method="GET">
            <label for="category" class="block text-gray-700 font-bold mb-2">Filter by Category:</label>
            <select name="category" id="category" class="p-3 border rounded-lg w-full focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Products Table -->
    <div class="mt-6 bg-white p-6 shadow-md rounded-lg">
        @if ($products->isEmpty())
            <p class="text-gray-600 text-center text-lg">No products available in this category.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-700">Image</th>
                            <th class="p-4 text-left font-semibold text-gray-700">SKU</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Name</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Barcode</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Quantity</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Cost Price</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Price</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Supplier Code</th>
                            @if (auth()->user() && auth()->user()->hasPermission('Update'))
                                <th class="p-4 text-left font-semibold text-gray-700">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="p-4 border-b text-gray-800">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded shadow">
                                    @else
                                        <div class="w-16 h-16 flex items-center justify-center bg-gray-100 text-gray-400 rounded shadow">
                                            <span class="text-xs">No Image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4 border-b text-gray-800">{{ $product->sku }}</td>
                                <td class="p-4 border-b text-gray-800">{{ $product->name }}</td>
                                <td class="p-4 border-b text-gray-800">
                                    @if ($product->barcode)
                                        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!}
                                        <p class="text-sm mt-2">{{ $product->barcode }}</p>
                                    @else
                                        <p class="text-sm text-red-500">No Barcode</p>
                                    @endif
                                </td>
                                <td class="p-4 border-b text-gray-800">{{ $product->quantity }}</td>
                                <td class="p-4 border-b text-gray-800">${{ number_format($product->cost_price, 2) }}</td>
                                <td class="p-4 border-b text-gray-800">${{ number_format($product->price, 2) }}</td>
                                <td class="p-4 border-b text-gray-800">{{ $product->supplier_code }}</td>
@if (auth()->user() && auth()->user()->hasPermission('Update'))
                                <td class="p-4 border-b">
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition duration-200" 
                                       title="Edit Product">
                                        Edit
                                    </a>
                                    <form action="{{ route('products.delete', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this product?')" 
                                                title="Delete Product">
                                            Delete
                                        </button>
                                    </form>
                                </td>
@endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>