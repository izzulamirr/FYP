@extends('layouts.app')

<!-- Header with Username -->
<div class="ml-64 p-8 w-full">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Transaction Summary</h1>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Item ID</th>
                    <th class="border p-2">Item Name</th>
                    <th class="border p-2">Quantity</th>
                    <th class="border p-2">Price</th>
                    <th class="border p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction['items'] as $item)
                    <tr>
                        <td class="border p-2">{{ $item['id'] }}</td>
                        <td class="border p-2">{{ $item['name'] }}</td>
                        <td class="border p-2">{{ $item['quantity'] }}</td>
                        <td class="border p-2">RM{{ number_format($item['price'], 2) }}</td>
                        <td class="border p-2">RM{{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('transactions.confirm') }}" method="POST">
            @csrf
            <label for="payment_method" class="block mt-4 mb-2 font-semibold">Payment Method</label>
            <select name="payment_method" id="payment_method" class="border p-2 rounded w-full" required>
                <option value="Cash">Cash</option>
                <option value="Online Banking"> QR </option>
                <option value="Credit Card">Credit Card / Debit Card </option>
                <option value="Ewallet">Ewallet</option>
            </select>
            <p class="mt-4 text-lg font-bold">Total Price: RM{{ number_format($transaction['total'], 2) }}</p>
            <button type="submit" class="bg-green-500 text-white p-2 rounded mt-4">Confirm Purchase</button>
        </form>
    </div>
</div>