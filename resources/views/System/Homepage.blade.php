<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Smart Inventory</h1>
           <!-- <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                Register
            </a> -->
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16 text-center">
        <h1 class="text-5xl font-extrabold text-gray-800">Welcome to <span class="text-blue-500">Smart Inventory</span></h1>
        <p class="text-lg text-gray-600 mt-4">Easily manage your stock, track inventory, and optimize your business operations.</p>

        <!-- Login Section -->
        <div class="mt-12 max-w-md mx-auto bg-white p-8 shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Staff Login</h2>

            <!-- Error and status messages -->
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-left">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-left text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-left text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Login
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Smart Inventory. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>