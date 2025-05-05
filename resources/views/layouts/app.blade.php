<!-- Sidebar -->

<body class="bg-gray-100 flex">
<script src="https://cdn.tailwindcss.com"></script>

<div class="w-64 h-screen bg-gray-800 text-white fixed top-0 left-0">
    <div class="p-5 text-center text-xl font-bold border-b border-gray-600">Smart Inventory</div>
    <nav class="mt-4">
        <ul>
            <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('dashboard') }}" class="flex items-center"><span class="mr-3">🏠</span> Dashboard</a></li>
            <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('transactions.index') }}" class="flex items-center"><span class="mr-3">💰</span> Transaction</a></li>
            <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Inventory') }}" class="flex items-center"><span class="mr-3">📦</span> Inventory</a></li>
            
            <!-- Supplies with Dropdown -->
            <li class="px-4 py-3 hover:bg-gray-700">
                <button class="w-full flex items-center text-left" onclick="toggleDropdown('suppliesDropdown')">
                    <span class="mr-3">📊</span> Suppliers
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="suppliesDropdown" class="hidden pl-6 mt-2 space-y-2">
                    <li>
                        <a href="{{ route('Supply') }}" class="flex items-center hover:bg-gray-700 p-2 rounded-lg">
                            Suppliers Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('suppliers.list') }}" class="flex items-center hover:bg-gray-700 p-2 rounded-lg">
                            View Suppliers
                        </a>
                    </li>
                </ul>
            </li>

            <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('reports.dashboard') }}" class="flex items-center"><span class="mr-3">📊</span> Report</a></li>
            <li class="px-4 py-3 hover:bg-gray-700"><a href="{{ route('Staff') }}" class="flex items-center"><span class="mr-3">🏠</span> Staff</a></li>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full text-left text-white">
                    <li class="px-4 py-3 hover:bg-gray-700" class="flex items-center"><span class="mr-3">🚪</span> Log Out
                </button>
            </form>
        </ul>
    </nav>
</div>
<div class="bg-gray-100 flex">

<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
    }
</script>