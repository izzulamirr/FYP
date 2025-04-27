
@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Products in Category: {{ $category }}</h1>
    </div>

    <!-- Categories Dropdown -->
    <div class="mt-4">
        <form action="{{ route('products.list') }}" method="GET">
            <label for="category" class="block text-gray-700 font-bold mb-2">Filter by Category:</label>
            <select name="category" id="category" class="p-2 border rounded w-full" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Products Table -->
    <div class="p-8 w-full">
        @if ($products->isEmpty())
            <p class="text-gray-600">No products available in this category.</p>
        @else
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Barcode</th>
                        <th class="p-3 text-left">Quantity</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Supplier Code</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="p-3 border-b">{{ $product->sku }}</td>
                            <td class="p-3 border-b">{{ $product->name }}</td>
                            <td class="p-3 border-b">
                                @if ($product->barcode)
                                    {!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!} <!-- Generate Barcode -->
                                    <p class="text-sm mt-2">{{ $product->barcode }}</p> <!-- Display Barcode Number -->
                                @else
                                    <p class="text-sm text-red-500">No Barcode</p> <!-- Display a message if barcode is null -->
                                @endif
                            </td>
                            <td class="p-3 border-b">{{ $product->quantity }}</td>
                            <td class="p-3 border-b">${{ number_format($product->price, 2) }}</td>
                            <td class="p-3 border-b">{{ $product->supplier_code }}</td>
                            <td class="p-3 border-b">
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600" title="Edit Product">Edit</a>
                                <form action="{{ route('products.delete', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete Product">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
    {{ $products->links() }}
</div>
        @endif
    </div>
</div>