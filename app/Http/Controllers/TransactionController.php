<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Product;

use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::all(); // Fetch all transactions
        return view('System.Transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id); // Fetch the transaction by ID
        return view('System.Transactions.show', compact('transaction'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);
    
        $totalPrice = 0;
        $purchasedProducts = [];
    
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
    
            if ($product->quantity < $productData['quantity']) {
                return response()->json(['success' => false, 'message' => "Not enough stock for product: {$product->name}"]);
            }
    
            // Decrease product quantity
            $product->quantity -= $productData['quantity'];
            $product->save();
    
            // Calculate total price and prepare product details
            $productTotal = $product->price * $productData['quantity'];
            $totalPrice += $productTotal;
    
            $purchasedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $productData['quantity'],
                'price' => $product->price,
            ];
        }
    
        // Create the transaction
        Transaction::create([
            'order_id' => uniqid('ORD'),
            'products' => json_encode($purchasedProducts),
            'quantity' => array_sum(array_column($purchasedProducts, 'quantity')),
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
        ]);
    
        return response()->json(['success' => true, 'message' => 'Transaction completed successfully!']);
    }
}
