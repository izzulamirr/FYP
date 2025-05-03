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

    public function finalize(Request $request)
    {
        $items = $request->input('items'); // Items sent from the frontend
        $total = $request->input('total'); // Total price sent from the frontend
    
        // Add name and price to each item and reduce product quantities in the database
        foreach ($items as &$item) { // Use reference to modify the array
            $product = Product::find($item['id']); // Find the product in the database
            if ($product) {
                $product->quantity -= $item['quantity']; // Reduce the quantity
                $product->save();
    
                // Add the name and price of the product to the item
                $item['name'] = $product->name;
                $item['price'] = $product->price;
            }
        }
    
        // Store transaction details in the session for the summary page
        session(['transaction' => ['items' => $items, 'total' => $total]]);
    
        return response()->json(['success' => true]); // Return success response
    }

    public function summary()
    {
        $transaction = session('transaction', null);
    
        if (!$transaction) {
            return redirect()->back()->with('error', 'No transaction data found.');
        }
    
        // Debugging: Check the session data
      
        return view('System.TransactionSummary', ['transaction' => $transaction]);
    }

    public function confirm()
{
    // Retrieve the transaction details from the session
    $transaction = session('transaction', null);

    if (!$transaction) {
        return redirect()->route('dashboard')->with('error', 'No transaction data found.');
    }

    // Optionally store the transaction in the database
    Transaction::create([
        'order_id' => uniqid('ORD'),
        'products' => json_encode($transaction['items']),
        'quantity' => array_sum(array_column($transaction['items'], 'quantity')),
        'total_price' => $transaction['total'],
        'payment_method' => 'Cash', // You can replace this with a dynamic value if needed
    ]);

    // Clear the session data
    session()->forget('transaction');

    // Redirect to the dashboard with a success message
    return redirect()->route('dashboard')->with('success', 'Transaction confirmed successfully!');
}
}
