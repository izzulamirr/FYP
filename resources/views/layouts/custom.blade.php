<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 h-screen bg-gray-800 text-white fixed top-0 left-0">
        <div class="p-5 text-center text-xl font-bold border-b border-gray-600">Smart Inventory</div>
        <nav class="mt-4">
            <ul>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('dashboard') }}" class="flex items-center"><span class="mr-3">🏠</span> Dashboard</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Transaction') }}" class="flex items-center"><span class="mr-3">💰</span> Transaction</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Inventory') }}" class="flex items-center"><span class="mr-3">📦</span> Inventory</a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Supply') }}" class="flex items-center"><span class="mr-3">📊</span> Supplies </a></li>
                <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Report') }}" class="flex items-center"><span class="mr-3">📊</span>  Report</a></li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left text-white">
                        <li class="px-4 py-3 hover:bg-gray-700" class="flex items-center"><span class="mr-3">🚪</span> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Main Content -->
    <div class="ml-64 p-8 w-full">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome to your inventory system.</p>
    </div>

</body>
</html>
