<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 h-screen bg-gray-900 text-white fixed top-0 left-0 flex flex-col">
        <!-- Logo Section -->
        <div class="p-5 text-center text-2xl font-bold border-b border-gray-700">
            Smart Inventory
        </div>

        <!-- Navigation -->
        <nav class="flex-grow mt-4">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">🏠</span> Dashboard
                    </a>
                </li>
                 <!-- Transactinon -->
                <li>
                    <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">🏠</span> Transactions
                    </a>
                </li>

                <!-- Inventory Dropdown -->
                <li>
                    <button class="w-full flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200" onclick="toggleDropdown('inventoryDropdown')">
                        <span class="mr-3">📦</span> Inventory
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <ul id="inventoryDropdown" class="hidden pl-6 mt-2 space-y-2">
                        <li>
                            <a href="{{ route('Inventory') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
                                Inventory Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.catagories') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
                                By Categories
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Suppliers Dropdown -->
                <li>
                    <button class="w-full flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200" onclick="toggleDropdown('suppliersDropdown')">
                        <span class="mr-3">📊</span> Suppliers
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <ul id="suppliersDropdown" class="hidden pl-6 mt-2 space-y-2">
                        <li>
                            <a href="{{ route('suppliers.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
                                Suppliers Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('supplies.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
                                View Orders
                            </a>
                        </li>
                        @if (Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('orders.restock') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
                                Restock Inventory
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                <!-- Reports -->
                <li>
                    <a href="{{ route('reports.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">📊</span> Reports
                    </a>
                </li>

                <!-- Staff -->
                @if (Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">👥</span> Staff
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-600 bg-red-500 rounded-lg transition duration-200">
                <span class="mr-3">🚪</span> Log Out
            </button>
        </form>
    </div>

    

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
</html>