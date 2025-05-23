@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="ml-64 p-8 w-full">
        <!-- Header -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
        </div>
        @if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <!-- Edit Product Form -->

     <!-- Show current image -->
@if($product->image)
    <div class="mb-4 flex justify-center">
        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-64 h-64 object-cover rounded mb-2 shadow">
    </div>
@endif
    
      <!-- File input for new image 
    <div class="mb-4">
        <label for="image" class="block font-semibold mb-1">Change Image</label>
        <input type="file" name="image" id="image" accept="image/*" class="block w-full">
        <small class="text-gray-500">Leave blank to keep current image.</small>
    </div>-->
  

            <!-- SKU (Non-editable) -->
            <div class="mb-4">
                <label for="sku" class="block text-gray-700 font-bold mb-2">SKU</label>
                <p class="p-2 border rounded w-full bg-gray-100">{{ $product->sku }}</p>
            </div>

            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" placeholder="Enter product name" required class="p-2 border rounded w-full">
            </div>
            
            
            <div class="mb-4">
    <label for="barcode" class="block text-gray-700 font-bold mb-2">Barcode</label>
    <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" class="p-2 border rounded w-full bg-gray-100" readonly>
</div>

            <!-- Quantity -->
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" name="quantity" min="0" id="quantity" value="{{ $product->quantity }}" placeholder="Enter product quantity" required class="p-2 border rounded w-full">
            </div>

            <!-- Cost Price -->
            <div class="mb-4">
                <label for="cost price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ $product->cost_price }}" placeholder="Enter product cost price" required class="p-2 border rounded w-full">
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ $product->price }}" placeholder="Enter product price" required class="p-2 border rounded w-full">
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                <input type="text" name="category" id="category" value="{{ $product->category }}" placeholder="Enter product category" required class="p-2 border rounded w-full">
            </div>

            <!-- Supplier Code -->
    <div class="mb-4">
        <label for="supplier_code" class="block text-gray-700 font-bold mb-2">Supplier Code</label>
        <p class="p-2 border rounded w-full bg-gray-100">{{ $product->supplier_code}}</p> 
       </div>

       <!-- Supplier Code  <div class="mb-4">
    <label for="image" class="block text-gray-700 font-bold mb-2">Product Image</label>
    <input type="file" name="image" id="image" class="p-2 border rounded w-full">
</div>--> 
            <!-- Submit and Delete Buttons Row -->
<!-- Update Product Form -->
<form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
    @csrf
    @method('PUT')
    <!-- ...your update fields and Update Product button... -->
    <div class="flex justify-between items-center mt-6">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded shadow">
            Update Product
        </button>
    </div>
</form>

<!-- Delete Product Form (OUTSIDE the update form) -->
@if(auth()->user() && auth()->user()->hasPermission('Delete'))
<div class="flex justify-end mt-4">
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded shadow">
            Delete Product
        </button>
    </form>
</div>
@endif
</body>
</html>