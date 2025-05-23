<!-- filepath: resources/views/System/Staff/index.blade.php -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Current Role</th>
            <th>Change Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>
                <form action="{{ route('staff.updateRole', $user->id) }}" method="POST">
                    @csrf
                    <select name="role" class="border rounded p-1">
                        <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
                        <option value="staff" @if($user->role=='staff') selected @endif>Staff</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>