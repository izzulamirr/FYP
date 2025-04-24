

@extends('layouts.app')

@section('content')





<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Products in Category: {{ $category }}</h1>
    </div>


    

    <div class="p-8 w-full">
        <!-- Products Table -->
        @if ($products->isEmpty())
            <p class="text-gray-600">No products available in this category.</p>
        @else
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Quantity</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Supplier Code</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="p-3">{{ $product->sku }}</td>
                            <td class="p-3">{{ $product->name }}</td>
                            <td class="p-3">{{ $product->quantity }}</td>
                            <td class="p-3">${{ number_format($product->price, 2) }}</td>
                            <td class="p-3">{{ $product->supplier_code }}</td>
                            <td class="p-3">
                            <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 text-white p-2 rounded">Edit</a>
                                <form action="{{ route('products.delete', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>