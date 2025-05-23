<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-bold mb-1">Name</label>
                <input id="name" class="w-full border rounded px-3 py-2" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            </div>

            <div class="mb-4">
                <label for="email" class="block font-bold mb-1">Email</label>
                <input id="email" class="w-full border rounded px-3 py-2" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            </div>

            <div class="mb-4">
                <label for="password" class="block font-bold mb-1">Password</label>
                <input id="password" class="w-full border rounded px-3 py-2" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-bold mb-1">Confirm Password</label>
                <input id="password_confirmation" class="w-full border rounded px-3 py-2" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mb-4">
                <label for="role" class="block font-bold mb-1">Role</label>
                <select id="role" name="role" class="w-full border rounded px-3 py-2" required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Register
                </button>
            </div>
        </form>
    </div>
</body>
</html>