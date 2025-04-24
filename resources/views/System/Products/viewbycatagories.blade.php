@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Products in Category: {{ $category }}</h1>

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">SKU</th>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Quantity</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Supplier</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-b">
                    <td class="p-3">{{ $product->sku }}</td>
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->quantity }}</td>
                    <td class="p-3">${{ number_format($product->price, 2) }}</td>
                    <td class="p-3">{{ $product->supplier->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center">No products found in this category.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection