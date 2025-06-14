
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

       

        <!-- Error Notification -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Add Product Form -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

            @csrf
      <div class="mb-4">
    <label for="sku" class="block text-gray-700 font-bold mb-2">SKU</label>
    <input type="text" name="sku" id="sku" value="{{ $sku }}" readonly class="p-2 border rounded w-full bg-gray-100">
</div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Enter product name" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter product quantity" required class="p-2 border rounded w-full">
            </div>
             <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" step="0.01"  min="0" name="price" id="price" placeholder="Enter product price" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="cost_price" class="block text-gray-700 font-bold mb-2">Cost price</label>
                <input type="number" step="0.01"    min="0" name="cost_price" id="cost_price" placeholder="Enter product cost_price" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                <input type="text" name="category" id="category" placeholder="Enter product category" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
    <label for="supplier_code" class="block text-gray-700 font-bold mb-2">Supplier Code</label>
    <select name="supplier_code" id="supplier_code" required class="p-2 border rounded w-full">
        <option value="" disabled selected>Select a supplier</option>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->supplier_code }}">{{ $supplier->supplier_code }} - {{ $supplier->name }}</option>
        @endforeach
    </select>
</div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Product Image</label>
               <input type="file" name="image" accept="image/*" class="p-2 border rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Product</button>
        </form>
    </div>
</body>
</html>