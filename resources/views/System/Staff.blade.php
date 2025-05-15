
@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
        <a href="{{ route('staff.create') }}" 
           class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
            + Add Staff
        </a>
    </div>

    <!-- Staff Cards -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($users as $user)
            <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-100 text-blue-600 w-12 h-12 flex items-center justify-center rounded-full text-xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4"><span class="font-semibold">Role:</span> {{ ucfirst($user->role) }}</p>
                <div class="flex space-x-2">
                    <!-- Edit Button -->
                    <a href="{{ route('staff.edit', $user->id) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition duration-300">
                        Edit
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('staff.destroy', $user->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center">
                <p class="text-gray-600 text-lg">No staff found.</p>
            </div>
        @endforelse
    </div>
</div>
