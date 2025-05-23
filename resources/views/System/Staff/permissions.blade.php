@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
        <h2 class="text-2xl font-bold mb-4">Manage Permissions for {{ $user->name }}</h2>
        <p class="mb-2"><span class="font-semibold">Role:</span> {{ ucfirst(optional($user->role)->name ?? 'N/A') }}</p>
        <form action="{{ route('staff.updatePermissions', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <span class="font-semibold">Permissions:</span>
                <table class="min-w-full mt-2 border">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b text-left">Permission</th>
                            <th class="px-4 py-2 border-b text-left">Allow</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPermissions as $permission)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $permission->Description }}</td>
                            <td class="px-4 py-2 border-b">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->PermissionID }}"
                                    class="form-checkbox"
                                    {{ $user->role && $user->role->permissions->contains('PermissionID', $permission->PermissionID) ? 'checked' : '' }}>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex gap-2 mt-4">
                <a href="{{ route('staff.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Back</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Update Permissions</button>
            </div>
        </form>
    </div>
</div>
