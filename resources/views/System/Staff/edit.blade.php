@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Edit Staff</h1>
        <form action="{{ route('staff.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                <select name="role" id="role" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                Update Staff
            </button>
        </form>
    </div>
</div>
