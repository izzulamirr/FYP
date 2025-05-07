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
    <!-- Main Content -->
    <div class="ml-64 p-8 w-full">
        <!-- Header -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Staff Dashboard</h1>
            <a href="{{ route('staff.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                Add Staff
            </a>
        </div>

        <!-- Staff Cards -->
        <div class="mt-6 grid grid-cols-3 gap-6">
            @forelse ($users as $user) <!-- Loop through $users and define each as $user -->
                <div class="bg-white p-6 shadow-md rounded-lg hover:bg-gray-100">
                    <h2 class="text-xl font-semibold mb-2">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-2">Email: {{ $user->email }}</p>
                    <p class="text-gray-600 mb-4">Role: {{ ucfirst($user->role) }}</p>
                    <div class="flex space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('staff.edit', $user->id) }}" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-200">
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('staff.destroy', $user->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No staff found.</p>
            @endforelse
        </div>
    </div>
</body>