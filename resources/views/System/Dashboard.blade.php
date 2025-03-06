@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
    </h2>
@endsection

@section('content')
    <div class="flex justify-between gap-6">
        <!-- Transactions Card -->
        <div class="bg-white shadow-md rounded-lg p-6 w-1/2">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Transactions</h3>
            <p class="text-gray-600">View and manage recent transactions.</p>
            <div class="mt-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Transactions</button>
            </div>
        </div>

        <!-- Product Summary Card -->
        <div class="bg-white shadow-md rounded-lg p-6 w-1/2">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Product Summary</h3>
            <p class="text-gray-600">Track stock levels and product availability.</p>
            <div class="mt-4">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">View Products</button>
            </div>
        </div>
    </div>
@endsection
