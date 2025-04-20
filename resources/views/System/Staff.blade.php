
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
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Staff Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>

        <!-- Add Staff Form -->
        <form action="{{ route('staff.store') }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
            @csrf
            <input type="text" name="name" placeholder="Staff Name" required class="p-2 border rounded w-full mb-4">
            <input type="email" name="email" placeholder="Staff Email" required class="p-2 border rounded w-full mb-4">
            <input type="password" name="password" placeholder="Password" required class="p-2 border rounded w-full mb-4">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Staff</button>
        </form>

        <!-- Staff Cards -->
        <div class="mt-6 grid grid-cols-3 gap-6">
    @forelse ($users as $user)
        <div class="bg-white p-6 shadow-md rounded-lg hover:bg-gray-100">
            <h2 class="text-xl font-semibold mb-2">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-2">Email: {{ $user->email }}</p>
            <p class="text-gray-600 mb-4">Role: {{ ucfirst($user->role) }}</p>
            <form action="{{ route('staff.destroy', $user->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete</button>
            </form>
        </div>
    @empty
        <p class="text-gray-600">No users found.</p>
    @endforelse
</div>
    </div>
</body>
