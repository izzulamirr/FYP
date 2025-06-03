@extends('layouts.app')

@section('content')
<div class="ml-64 p-3 w-full">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-5 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
        <a href="{{ route('staff.create') }}" 
           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition duration-300">
            + Add Staff
        </a>
    </div>

     <!-- Success Notification -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </button>
            </div>
        @endif
        @if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
    @foreach ($users as $user)
    <div class="bg-white p-8 rounded-2xl shadow-lg flex flex-col items-center hover:shadow-2xl transition-shadow duration-300">
        @if($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}"
                 alt="Profile Picture"
                 class="w-20 h-20 rounded-full object-cover mb-4 shadow border border-gray-200">
        @else
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-4 shadow">
                <span class="text-3xl font-bold text-blue-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
        @endif
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