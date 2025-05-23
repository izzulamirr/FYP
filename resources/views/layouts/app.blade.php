<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">  
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style> 
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex fade-enter">

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
                        <span class="mr-3">
                            <!-- Home Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v6a2 2 0 002 2h4a2 2 0 002-2v-6m-6 0h6" />
                            </svg>
                        </span>
                        Dashboard
                    </a>
                </li>

                <!-- Transactions -->
                <li>
                    <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">
                            <!-- Credit Card Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2M5 11h14M5 15h14M7 19h10a2 2 0 002-2v-6a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                        </span>
                        Transactions
                    </a>
                </li>

                <!-- Inventory Dropdown -->
                <li>
                    <button class="w-full flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200" onclick="toggleDropdown('inventoryDropdown')">
                        <span class="mr-3">
                            <!-- Cube Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12l-8 4-8-4m16 0l-8-4-8 4m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6" />
                            </svg>
                        </span>
                        Inventory
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <ul id="inventoryDropdown" class="hidden pl-6 mt-2 space-y-2">
                        <li>
                            <a href="{{ route('inventory.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-200">
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
                        <span class="mr-3">
                            <!-- Truck Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-6 0a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2m-6 0a2 2 0 01-2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2" />
                            </svg>
                        </span>
                        Suppliers
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
@if (\App\Models\Role::where('name', 'admin')->where('user_id', Auth::id())->exists())                        <li>
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
                        <span class="mr-3">
                            <!-- Chart Bar Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4 0v-2a2 2 0 012-2h2a2 2 0 012 2v2m4 0v-10a2 2 0 00-2-2h-2a2 2 0 00-2 2v10" />
                            </svg>
                        </span>
                        Reports
                    </a>
                </li>

                <!-- Staff -->
@if (\App\Models\Role::where('name', 'admin')->where('user_id', Auth::id())->exists())                <li>
                    <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 rounded-lg transition duration-200">
                        <span class="mr-3">
                            <!-- Users Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 010 7.75" />
                            </svg>
                        </span>
                        Staff
                    </a>
                </li>
                @endif
            </ul>
        </nav>

          <!-- Back Button -->
        <button onclick="window.history.back();" class="mx-4 my-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </button>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="relative w-full flex items-center px-4 py-3 rounded-lg overflow-hidden group transition duration-200">
                <span class="absolute inset-0 bg-red-500 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                <span class="relative flex items-center text-white group-hover:text-white transition duration-200">
                    <span class="mr-3">
                        <!-- Logout Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                    </span>
                    Log Out
                </span>
            </button>
        </form>
    </div>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.querySelector('body');
            body.classList.add('fade-enter-active');
        });
    </script>
</body>
</html>