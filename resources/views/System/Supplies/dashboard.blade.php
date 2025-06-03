@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Supplies Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="ml-64 p-3 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-5 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        <!-- Total Suppliers -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Suppliers</h2>
            <p class="text-4xl font-bold mt-2">{{ $totalSuppliers }}</p>
        </div>

        <!-- Active Suppliers -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Active Suppliers</h2>
            <p class="text-4xl font-bold mt-2">{{ $activeSuppliers }}</p>
        </div>

        <!-- Inactive Suppliers -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Inactive Suppliers</h2>
            <p class="text-4xl font-bold mt-2">{{ $inactiveSuppliers }}</p>
        </div>
    </div>

     <!-- Success Notification -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </button>
            </div>
        @endif
        @if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Suppliers List Card -->
    <div class="mt-4 bg-white p-2 shadow-lg rounded-lg mb-4 flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 mb-0">Suppliers List</h2>
        @if (auth()->user() && auth()->user()->hasPermission('Create'))
            <a href="{{ route('suppliers.create') }}" 
               class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                + Add New Supplier
            </a>
        @endif
    </div>

    <!-- Suppliers Table Card -->
    <div class="bg-white p-0 shadow-lg rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead style="background-color: #1e293b;">
                    <tr>
                        <th class="p-4 text-left font-semibold text-white">Supplier Code</th>
                        <th class="p-4 text-left font-semibold text-white">Name</th>
                        <th class="p-4 text-left font-semibold text-white">Email</th>
                        <th class="p-4 text-left font-semibold text-white">Phone</th>
                        <th class="p-4 text-left font-semibold text-white">Status</th>
                        @if (Auth::user()->role === 'admin')
                            <th class="p-4 text-left font-semibold text-white">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="p-4 border-b text-gray-800">{{ $supplier->supplier_code }}</td>
                            <td class="p-4 border-b text-gray-800">{{ $supplier->name }}</td>
                            <td class="p-4 border-b text-gray-800">{{ $supplier->email ?? 'N/A' }}</td>
                            <td class="p-4 border-b text-gray-800">{{ $supplier->phone ?? 'N/A' }}</td>
                            <td class="p-4 border-b">
                                @if ($supplier->products->isNotEmpty())
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Inactive</span>
                                @endif
                            </td>
                            @if (Auth::user()->role === 'admin')
                            <td class="p-4 border-b">
                                <div class="flex space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('suppliers.edit', $supplier->supplier_code) }}" 
                                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition duration-200">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('suppliers.destroy', $supplier->supplier_code) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
