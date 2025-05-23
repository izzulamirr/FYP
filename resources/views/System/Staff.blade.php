@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
        <a href="{{ route('staff.create') }}" 
           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition duration-300">
            + Add Staff
        </a>
    </div>

    <!-- Staff Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
        @foreach ($users as $user)
        <div class="bg-white p-8 rounded-2xl shadow-lg flex flex-col items-center hover:shadow-2xl transition-shadow duration-300">
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-4 shadow">
                <span class="text-3xl font-bold text-blue-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <h2 class="text-xl font-bold mb-1 text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500 mb-1 text-sm"><span class="font-semibold">Email:</span> {{ $user->email }}</p>
            <p class="text-gray-500 mb-1 text-sm">
                <span class="font-semibold">Role:</span> {{ ucfirst(optional($user->role)->name ?? 'N/A') }}
            </p>
            <p class="text-gray-500 mb-4 text-sm">
                <span class="font-semibold">Permissions:</span>
                @if($user->role && $user->role->permissions)
                    {{ $user->role->permissions->pluck('Description')->join(', ') }}
                @else
                    N/A
                @endif
            </p>
                        <div class="flex gap-3 mt-2 w-full">
                <a href="{{ route('staff.edit', $user->id) }}" class="flex-1 bg-yellow-400 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-500 transition text-center">Edit Profile</a>
                <a href="{{ route('staff.permissions', $user->id) }}" class="flex-1 bg-purple-500 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-600 transition text-center">Manage Permissions</a>
                <form action="{{ route('staff.destroy', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition text-center">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
