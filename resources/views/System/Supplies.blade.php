@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Suppliers</title>
    
</head>


<!-- Main Content -->
<div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800"> Suppliers Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>
        

<!-- Suppliers Slideshow -->
<div class="relative overflow-hidden bg-gray-200 rounded-lg" style="width: 1200px; margin: 10px auto;">
    <div id="supplier-slides" class="flex transition-transform duration-500" style="width: 100%; white-space: nowrap;">
        @foreach ($suppliers as $supplier)
            <div class="bg-white p-4 shadow-md rounded-lg w-[400px] inline-block hover:bg-blue-200" style="margin-right: 20px;">
                <h2 class="text-xl font-semibold mb-2">{{ $supplier->name }}</h2>
                <p class="text-gray-600">Contact: {{ $supplier->phone ?? 'N/A' }}</p>
                <p class="text-gray-600">Email: {{ $supplier->email ?? 'N/A' }}</p>
            </div>
        @endforeach
    </div>
    <!-- Navigation Buttons -->
    <button id="prev-slide" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
        &#10094;
    </button>
    <button id="next-slide" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
        &#10095;
    </button>
</div>

<!-- Slideshow Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.getElementById('supplier-slides');
        const prevButton = document.getElementById('prev-slide');
        const nextButton = document.getElementById('next-slide');
        let currentIndex = 0;

        const slideWidth = 420; // Width of each slide (400px + 20px margin)

        const updateSlidePosition = () => {
            slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        };

        nextButton.addEventListener('click', () => {
            if (currentIndex < slides.children.length - 3) { // Show 3 slides at a time
                currentIndex++;
                updateSlidePosition();
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlidePosition();
            }
        });
    });
</script>
        
 <!-- Order history -->
 <div class="mt-6 bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Order History</h2>

            <div class="mt-3 overflow-auto max-h-[400px]">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">Order Date</th>
                        <th class="p-3 text-left">Delivery Type</th>
                        <th class="p-3 text-left">Tracking ID </th>
                        <th class="p-3 text-left">Total Stock</th>
                        <th class="p-3 text-left">Payment Status</th>
                        <th class="p-3 text-left">Delivery Status</th>
                    </tr>
                </thead>
            </table>
        </div>



            