<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order; // Assuming you have an Order model
use App\Models\Supplier; // Assuming you have a Supplier model
use App\Models\Product; // Assuming you have an Inventory model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function index()
    {  
            // Fetch all orders from the database
            $orders = Order::all();
    
            // Pass the orders to the view
            return view('System.Supplies.Supplies', compact('orders'));
        
    }

    public function restock()
{
    // Fetch all suppliers
    $suppliers = Supplier::all();

    // Return the restock view
    return view('System.Supplies.restock', compact('suppliers'));
}

public function processRestock(Request $request)
{
    // Validate the request
    $request->validate([
        'supplier_code' => 'required|exists:suppliers,supplier_code',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Fetch the supplier and product details
    $supplier = Supplier::where('supplier_code', $request->supplier_code)->firstOrFail();
    $product = Product::findOrFail($request->product_id);

    // Calculate the total (assuming the product has a price field)
    $total = $product->cost_price * $request->quantity;

    // Create a new order
    Order::create([
        'order_id' => 'ORD' . strtoupper(uniqid()), // Generate a unique order ID
        'supplier_code' => $supplier->supplier_code,
        'supplier_name' => $supplier->name,
        'total' => $total,
        'delivery_status' => 'pending',
        'order_date' => now(),
    ]);

    // Redirect back with a success message
    return redirect()->route('orders.restock')->with('success', 'Order placed successfully.');
}
public function getProductsBySupplier($supplier_code)
{
    // Fetch products for the given supplier
    $products = Product::where('supplier_code', $supplier_code)->get(['id', 'name']);

    // Return the products as JSON
    return response()->json($products);
}

   
}