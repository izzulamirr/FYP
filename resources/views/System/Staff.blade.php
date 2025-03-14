@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Inventory - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Main Content -->
<div class="ml-64 p-8 w-full">
        <!-- Header with Username -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800"> Staff Dashboard</h1>
            <p class="text-gray-600">👤 {{ Auth::user()->name }}</p>
        </div>
        </div>

        
 