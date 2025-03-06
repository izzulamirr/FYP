<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Silver Theme Styling */
        body {
            background: linear-gradient(135deg, #dcdcdc, #f5f5f5);
            color: #333;
            font-family: Arial, sans-serif;
        }
        .header {
            background: #e0e0e0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }
        .btn-login {
            background: #999;
            color: white;
        }
        .btn-login:hover {
            background: #777;
        }
        .btn-register {
            background: #555;
            color: white;
        }
        .btn-register:hover {
            background: #333;
        }
    </style>
</head>
<body>

    <!-- Header with Login & Register -->
    <header class="header flex justify-between items-center px-6 py-4">
        <h2 class="text-xl font-bold text-gray-800">Smart Inventory</h2>
        <div>
            <a href="{{ route('login') }}" class="btn btn-login mr-3">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl font-bold text-gray-800">Welcome to Smart Inventory System</h1>
        <p class="text-lg text-gray-600 mt-4">Easily manage your stock, track inventory, and optimize your business.</p>
    </div>

</body>
</html>
