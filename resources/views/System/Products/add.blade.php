@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="ml-64 p-8 w-full">
        <!-- Header -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Add Product</h1>
        </div>

        <!-- Add Product Form -->
        <form action="{{ route('products.store') }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Enter product name" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea name="description" id="description" placeholder="Enter product description" required class="p-2 border rounded w-full"></textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" name="price" id="price" placeholder="Enter product price" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter product quantity" required class="p-2 border rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Product</button>
        </form>
    </div>
</body>
</html>