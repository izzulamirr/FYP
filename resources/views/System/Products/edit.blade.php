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

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <!-- Edit Product Form -->
    
  

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

            <!-- Quantity -->
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}" placeholder="Enter product quantity" required class="p-2 border rounded w-full">
            </div>

<<<<<<< HEAD
=======
            <!-- Cost Price -->
            <div class="mb-4">
                <label for="cost price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ $product->cost_price }}" placeholder="Enter product cost price" required class="p-2 border rounded w-full">
            </div>

>>>>>>> f94268b96abb02bfaf1fd5a059322493e9019696
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
            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update Product</button>
        </form>
    </div>
</body>
</html>