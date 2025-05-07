<!-- filepath: c:\xampp\htdocs\FYP\resources\views\System\SuppliersList.blade.php -->
@extends('layouts.app')

<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-lg rounded-lg">

    <a href="{{ route('Supply') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-200 mb-4 inline-block">
            ← Supplies
        </a>
        <h1 class="text-2xl font-bold mb-4">All Suppliers</h1>

        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Contact</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td class="p-3">{{ $supplier->name }}</td>
                        <td class="p-3">{{ $supplier->phone ?? 'N/A' }}</td>
                        <td class="p-3">{{ $supplier->email ?? 'N/A' }}</td>
                        <td class="p-3">{{ $supplier->address ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>