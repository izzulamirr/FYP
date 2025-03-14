@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Suppliers</title>
</head>


<!-- Main Content -->
<div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800"> Suppliers Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>


   <!-- Suppliers Slideshow -->
   <div class="flex overflow-x-auto space-x-4 p-4 bg-gray-200 rounded-lg">
        <div class="bg-white p-4 shadow-md rounded-lg w-96">
            <h2 class="text-xl font-semibold mb-2">Supplier 1</h2>
            <p class="text-gray-600">Contact: John Doe</p>
            <p class="text-gray-600">Email:
        </div>
    </div>
        
 <!-- Cashier System -->
 <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Order History</h2>

            <div class="mt-3 overflow-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">Order Date</th>
                        <th class="p-3 text-left">Delivery Type</th>
                        <th class="p-3 text-left">Tracking ID </th>
                        <th class="p-3 text-left">Total Stock</th>
                        <th class="p-3 text-left">Payment Status</th>
                        <th class="p-3 text-left">Delivery Status</th>
                    </tr>
                </thead>
            </table>
        </div>



            