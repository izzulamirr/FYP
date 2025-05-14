@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold">Add New Supplier</h2>
        <form action="{{ route('suppliers.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label for="supplier_code" class="block text-gray-700 font-bold mb-2">Supplier Code</label>
                <input type="text" name="supplier_code" id="supplier_code" placeholder="Enter supplier code" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Supplier Name</label>
                <input type="text" name="name" id="name" placeholder="Enter supplier name" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter supplier email" class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Enter supplier phone" class="p-2 border rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Supplier</button>
        </form>
    </div>
</div>