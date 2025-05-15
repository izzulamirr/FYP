
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Smart Inventory</h2>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-6 py-32 text-center">
            <h1 class="text-5xl font-extrabold text-gray-800 leading-tight">
                Welcome to <span class="text-blue-500">Smart Inventory System</span>
            </h1>
            <p class="text-lg text-gray-600 mt-4">
                Easily manage your stock, track inventory, and optimize your business operations.
            </p>
            <div class="mt-8">
                <a href="{{ route('login') }}" 
                   class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                    Login
                </a>
            </div>
             <div class="mt-8">
           <!-- <a href="{{ route('register') }}" 
               class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                Register
            </a>
        </div>-->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Smart Inventory. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>