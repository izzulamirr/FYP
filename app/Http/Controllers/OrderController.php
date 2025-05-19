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
    $request->validate([
        'supplier_code' => 'required|exists:suppliers,supplier_code',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $supplier = Supplier::where('supplier_code', $request->supplier_code)->firstOrFail();
    $product = Product::findOrFail($request->product_id);

    $products = [[
        'name' => $product->name,
        'quantity' => $request->quantity,
        'cost_price' => $product->cost_price,
    ]];

    $total = $product->cost_price * $request->quantity;

    Order::create([
        'order_id' => 'ORD' . strtoupper(uniqid()),
        'supplier_code' => $supplier->supplier_code,
        'supplier_name' => $supplier->name,
        'total' => $total,
        'delivery_status' => 'pending',
        'order_date' => now(),
        'products' => json_encode($products),
    ]);

    return redirect()->route('orders.restock')->with('success', 'Order placed successfully.');
}
public function getProductsBySupplier($supplier_code)
{
    // Fetch products for the given supplier
    $products = Product::where('supplier_code', $supplier_code)->get(['id', 'name']);

    // Return the products as JSON
    return response()->json($products);
}


public function showInvoice($order_id)
{
        $orders = Order::findOrFail($order_id); // Fetch the ction by ID

    // Pass the order to the invoice slip view
    return view('System.Supplies.invoice_slip', compact('orders', 'order_id'));
}



public function confirm($order_id)
{
    $order = Order::where('order_id', $order_id)->firstOrFail();

    // Decode products from the order
    $products = json_decode($order->products, true);

    // Update each product's quantity in the database
    foreach ($products as $prod) {
        $product = Product::where('name', $prod['name'])->first();
        if ($product) {
            $product->quantity += $prod['quantity'];
            $product->save();
        }
    }

    // Update order status
    $order->delivery_status = 'Delivered';
    $order->completed_date = now();
    $order->save();

    return redirect()->back()->with('success', 'Order confirmed and inventory updated!');
}
   
}