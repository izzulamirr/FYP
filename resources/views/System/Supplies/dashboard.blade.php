@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Suppliers Dashboard</h1>
        <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Total Suppliers -->
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Total Suppliers</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalSuppliers }}</p>
        </div>

        <!-- Pending Payments -->
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Pending Payments</h2>
            <p class="text-3xl font-bold mt-2">{{ $pendingPayments }}</p>
        </div>

        <!-- Pending Deliveries -->
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Pending Deliveries</h2>
            <p class="text-3xl font-bold mt-2">{{ $pendingDeliveries }}</p>
        </div>
    </div>

    <!-- Suppliers List Section -->
    <div class="mt-6 flex gap-5">
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Suppliers List</h2>
            <div class="overflow-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Supplier ID</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Phone</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td class="p-3">{{ $supplier->id }}</td>
                                <td class="p-3">{{ $supplier->name }}</td>
                                <td class="p-3">{{ $supplier->email }}</td>
                                <td class="p-3">{{ $supplier->phone }}</td>
                                <td class="p-3">
                                    @if ($supplier->is_active)
                                        <span class="text-green-500 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-500 font-semibold">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-gray-500">No suppliers available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
