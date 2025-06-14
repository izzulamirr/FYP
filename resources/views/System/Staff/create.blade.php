@extends('layouts.app')

@section('content')




<div class="ml-64 p-8 w-full">

@if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Add New Staff</h1>
<form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" 
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" 
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" 
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                <select name="role" id="role" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </div>

    <div class="mb-4">
    <label for="profile_picture" class="block font-semibold mb-1">Profile Picture</label>
    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full">
</div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                Add Staff
            </button>
        </form>
    </div>
</div>