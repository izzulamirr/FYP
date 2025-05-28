@extends('layouts.app')

@section('content')

<div class="ml-64 p-8 w-full bg-gray-50 min-h-screen">
    
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 shadow-md rounded-lg mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Inventory Dashboard</h1>
        <div class="flex items-center space-x-3">
            <span class="text-gray-600 text-lg">👤 {{ Auth::user()->name }}</span>
        </div>
    </div>

   <!-- Categories Section -->
    <div class="p-8 w-full">
        <div class="mt-6 bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
               @foreach ($categories as $index => $category)
    <a href="{{ route('products.catagories', ['category' => $category]) }}"
        class="category-btn p-6 shadow-md rounded-lg text-center cursor-pointer transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400
        @if($index % 10 === 0) bg-red-200 hover:bg-red-400
        @elseif($index % 10 === 1) bg-blue-200 hover:bg-blue-400
        @elseif($index % 10=== 2) bg-green-200 hover:bg-green-400
        @elseif($index % 10 === 3) bg-yellow-200 hover:bg-yellow-400
        @elseif($index % 10 === 4) bg-purple-200 hover:bg-purple-400
        @elseif($index % 10 === 5) bg-pink-200 hover:bg-pink-400
        @elseif($index % 10 === 6) bg-indigo-200 hover:bg-indigo-400
        @elseif($index % 10 === 7) bg-teal-200 hover:bg-teal-400
        @elseif($index % 10 === 8) bg-orange-200 hover:bg-orange-400
        @elseif($index % 10 === 9) bg-gray-200 hover:bg-gray-400
        
        @endif"
        data-category="{{ $category }}"
    >
        <h3 class="text-lg font-bold text-gray-800">{{ $category }}</h3>
    </a>
@endforeach
            </div>
        </div>
    </div>

    <!-- Add Product Button -->
    @if (auth()->user() && auth()->user()->hasPermission('Create'))
        <div class="mb-8 flex justify-end">
            <a href="{{ route('products.create') }}" 
               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition duration-200">
                ➕ Add Product
            </a>
        </div>
    @endif

     <!-- Success Notification -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/>
                    </svg>
                </button>
            </div>
        @endif
        @if ($errors->any())
    <div class="mb-4 text-red-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 @if($lowStockProducts->count() > 0)
<div 
    x-data="{
        start: 0,
        visible: 4,
        get items() { return {{ $lowStockProducts->toJson() }}; },
        get total() { return this.items.length; },
        next() { this.start = (this.start + this.visible) % this.total; },
        prev() { this.start = (this.start - this.visible + this.total) % this.total; },
        shown() {
            let arr = [];
            for(let i=0; i<this.visible; i++) {
                arr.push(this.items[(this.start + i) % this.total]);
            }
            return arr;
        }
    }"
    class="mb-8"
>
    <h2 class="text-lg font-bold text-red-700 mb-4 flex items-center gap-2">
        Low Stock Items
        <button @click="prev" class="ml-auto mr-2 bg-gray-200 hover:bg-gray-300 rounded-full p-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="next" class="bg-gray-200 hover:bg-gray-300 rounded-full p-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <template x-for="product in shown()" :key="product.id">
            <div class="bg-white border border-red-200 rounded-lg shadow p-4 flex flex-col items-center">
                <template x-if="product.image">
                    <img :src="'/storage/' + product.image" :alt="product.name" class="w-24 h-24 object-cover rounded mb-2">
                </template>
                <template x-if="!product.image">
                    <div class="w-24 h-24 flex items-center justify-center bg-gray-100 rounded text-gray-400 text-2xl border-2 border-dashed border-red-200 mb-2">
                        <span>No Image</span>
                    </div>
                </template>
                <div class="text-center w-full">
                    <h3 class="font-bold text-gray-800 mb-1" x-text="product.name"></h3>
                    <div class="text-sm text-gray-600 mb-1">Qty: <span class="font-semibold text-red-600" x-text="product.quantity"></span></div>
                    <div class="text-xs text-gray-500 mb-2">SKU: <span x-text="product.sku"></span></div>
                    <a :href="'{{ url('orders/restock') }}?product=' + product.id"
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-xs transition duration-200">
                        Restock
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>
@endif
   <!-- 10 Most Recent Products Grid -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">10 Most Recent Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($recentProducts as $product)
    <a href="{{ route('products.edit', $product->id) }}" class="block bg-white rounded-2xl shadow-xl hover:shadow-2xl transition p-6 flex flex-col items-center border border-blue-100 hover:ring-2 hover:ring-blue-400 focus:outline-none">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-xl mb-4 border-2 border-blue-200 shadow">
        @else
            <div class="w-48 h-48 flex items-center justify-center bg-gray-100 rounded-xl mb-4 text-gray-400 text-4xl border-2 border-dashed border-blue-200">
                <span>No Image</span>
            </div>
        @endif
        <div class="w-full text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-semibold">SKU: {{ $product->sku }}</span>
                <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-semibold">Barcode: {{ $product->barcode ?? '-' }}</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                <span class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Qty: {{ $product->quantity }}</span>
                <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs font-semibold">Price: RM{{ number_format($product->price, 2) }}</span>
            </div>
            @if (App\models\Role::whereIn('name', ['admin', 'manager'])->where('user_id', Auth::id())->exists())                           
            <div class="text-gray-600 text-xs mb-1"><span class="font-semibold">Cost:</span> RM{{ number_format($product->cost_price, 2) }}</div>
            @endif
            <div class="text-gray-600 text-xs mb-1"><span class="font-semibold">Category:</span> {{ $product->category }}</div>
            <div class="text-gray-600 text-xs mb-1"><span class="font-semibold">Supplier:</span> {{ $product->supplier_code }}</div>
        </div>
    </a>
@empty
    <div class="col-span-full text-center text-gray-400 italic">No products found.</div>
@endforelse
        </div>
    </div>
   
</div>
