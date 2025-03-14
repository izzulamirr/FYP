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
            <h1 class="text-2xl font-bold text-gray-800"> Suppliers Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>


        <!-- Categories -->
        <ul class="flex items-center bg-white p-4 shadow-md rounded-lg">
              <tr>
                        <th class="p-3 text-left">Food</th>
                        <th class="p-3 text-left">Hardware</th>
                        <th class="p-3 text-left">Utilities</th>
                        <th class="p-3 text-left">Electronics</th>
                    </tr>
          
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