@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold">Edit Supplier</h2>
     <form action="{{ route('suppliers.update', $supplier->supplier_code) }}" method="POST" class="mt-4">
    @csrf
    @method('PUT')
            <div class="mb-4">
                <label for="supplier_code" class="block text-gray-700 font-bold mb-2">Supplier Code</label>
                <input type="text" name="supplier_code" id="supplier_code" value="{{ $supplier->supplier_code }}" required class="p-2 border rounded w-full bg-gray-100">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Supplier Name</label>
                <input type="text" name="name" id="name" value="{{ $supplier->name }}" required class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ $supplier->email }}" class="p-2 border rounded w-full">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ $supplier->phone }}" class="p-2 border rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Supplier</button>
        </form>
    </div>
</div>