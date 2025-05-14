@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    

   <!-- Statistics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold">Total Suppliers</h2>
            <p class="text-4xl font-bold mt-2">{{ $totalSuppliers }}</p>
        </div>
    </div>

    <!-- Suppliers Table -->
   <div class="mt-8 bg-white p-6 shadow-lg rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Suppliers List</h2>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-300">
            + Add New Supplier
        </a>
    </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-4 text-gray-600 font-medium">Supplier Code</th>
                        <th class="border p-4 text-gray-600 font-medium">Name</th>
                        <th class="border p-4 text-gray-600 font-medium">Email</th>
                        <th class="border p-4 text-gray-600 font-medium">Phone</th>
                        <th class="border p-4 text-gray-600 font-medium">Status</th>
                        <th class="border p-4 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="border p-4">{{ $supplier->supplier_code }}</td>
                        <td class="border p-4">{{ $supplier->name }}</td>
                        <td class="border p-4">{{ $supplier->email ?? 'N/A' }}</td>
                        <td class="border p-4">{{ $supplier->phone ?? 'N/A' }}</td>
                        <td class="border p-4">
                            @if ($supplier->status === 'active')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Inactive</span>
                            @endif
                        </td>

                        <td class="border p-4">
    <div class="flex space-x-2">
        <a href="{{ route('suppliers.edit', $supplier->supplier_code) }}" class="text-blue-600 hover:underline">Edit</a>
        <form action="{{ route('suppliers.destroy', $supplier->supplier_code) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">Delete</button>
        </form>
    </div>
</td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border p-4 text-center text-gray-500">No suppliers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
