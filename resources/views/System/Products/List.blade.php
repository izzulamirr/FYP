@extends('layouts.app')

@section('content')

<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">All Products</h1>
    </div>

    <div class="p-8 w-full">
        <!-- Products Table -->
        @if ($products->isEmpty())
            <p class="text-gray-600">No products available.</p>
        @else
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Quantity</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Supplier Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="p-3">{{ $product->sku }}</td>
                            <td class="p-3">{{ $product->name }}</td>
                            <td class="p-3">{{ $product->quantity }}</td>
                            <td class="p-3">${{ number_format($product->price, 2) }}</td>
                            <td class="p-3">{{ $product->category }}</td>
                            <td class="p-3">{{ $product->supplier_code }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection