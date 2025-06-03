@extends('layouts.app')

@section('content')
<div class="ml-64 p-8 w-full min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-xl mx-auto border border-gray-200">
        <div class="flex flex-col items-center mb-6">
            {{-- Profile Image --}}
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-200 shadow mb-3 flex items-center justify-center bg-gray-100">
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"
                    class="object-cover w-full h-full" style="aspect-ratio: 1/1;">
            </div>
            <h2 class="text-2xl font-extrabold text-gray-800 mb-1">{{ $user->name }}</h2>
            <p class="text-gray-500 mb-1"><span class="font-semibold">Role:</span> {{ ucfirst(optional($user->role)->name ?? 'N/A') }}</p>
        </div>
        <form action="{{ route('staff.updatePermissions', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <span class="font-semibold text-gray-700">Permissions:</span>
                <div class="overflow-x-auto rounded-lg border border-gray-200 mt-3">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Permission</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Allow</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPermissions as $permission)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-3 border-b border-gray-100 text-gray-700">{{ $permission->Description }}</td>
                                <td class="px-6 py-3 border-b border-gray-100">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->PermissionID }}"
                                        class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                        {{ $user->role && $user->role->permissions->contains('PermissionID', $permission->PermissionID) ? 'checked' : '' }}>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex gap-3 justify-end">
                <a href="{{ route('staff.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 transition font-semibold shadow">Back</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold shadow">Update Permissions</button>
            </div>
        </form>
    </div>
</div>
