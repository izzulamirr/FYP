@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Transaction</title>
</head>


<!-- Main Content -->
<div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800"> Inventory Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>

        <div class="p-8 w-full">

        <!-- Categories -->
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg hover:bg-gray-200">
    <h2 class="text-xl font-semibold mb-4">Categories</h2>
    <div class="grid grid-cols-4 gap-4">
        <!-- Food Category -->
        <a href="{{ route('dashboard') }}" class="bg-white p-6 shadow-lg rounded-lg text-center hover:bg-blue-100">
            <p class="text-gray-600 font-semibold">Food</p>
        </a>
        
        <!-- Hardware Category -->
        <a href="{{ route('Report') }}" class="bg-white p-6 shadow-lg rounded-lg text-center hover:bg-red-100">
            <p class="text-gray-600 font-semibold">Hardware</p>
        </a>

        <!-- Electronics Category -->
        <a href="{{ route('Supply') }}" class="bg-white p-6 shadow-lg rounded-lg text-center hover:bg-yellow-100">
            <p class="text-gray-600 font-semibold">Electronics</p>
        </a>

        <!-- Stationery Category -->
        <a href="{{ route('dashboard') }}" class="bg-white p-6 shadow-lg rounded-lg text-center hover:bg-green-100">
            <p class="text-gray-600 font-semibold">Stationery</p>
        </a>
    </div>
</div>


          
        </ul>
        
        <!-- Products Table -->
        <div class="mt-3 overflow-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Quantity Left</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Supplier Code</th>
                    </tr>
                </thead>
                <tbody>
              
                </tbody>
            </table>
        </div>
    </div>
</div>