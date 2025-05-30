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
   public function index(Request $request)
{
    $query = Order::where('delivery_status', '!=', 'Rejected');
    
    // Filter by Order ID
    if ($request->filled('order_id')) {
        $query->where('order_id', 'like', '%' . $request->order_id . '%');
    }

    // Filter by date
    if ($request->filled('order_date')) {
        $query->whereDate('order_date', $request->order_date);
    }

    // Filter by supplier name
    if ($request->filled('supplier_name')) {
        $query->where('supplier_name', 'like', '%' . $request->supplier_name . '%');
    }

    // Filter by supplier code
    if ($request->filled('supplier_code')) {
        $query->where('supplier_code', 'like', '%' . $request->supplier_code . '%');
    }

    // Filter by delivery status
    if ($request->filled('delivery_status')) {
        $query->where('delivery_status', $request->delivery_status);
    }

$supplies = $query->orderBy('order_date', 'desc')->paginate(6);
    return view('System.Supplies.Supplies', compact('supplies'));
}

    public function restock()
{
    // Fetch all suppliers
    $products = \App\Models\Product::with('supplier')->get();

    // Return the restock view
    if (!auth()->user()->hasPermission('Restock')) {
    abort(403, 'Unauthorized');
}   else {
return view('System.Supplies.restock', compact('products'));
}
}

public function processRestock(Request $request)
{
    $request->validate([
        'supplier_code' => 'required|exists:suppliers,supplier_code',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Find the product
    $product = \App\Models\Product::where('id', $request->product_id)
        ->where('supplier_code', $request->supplier_code)
        ->first();

    if (!$product) {
        return back()->withErrors(['product_id' => 'Product and supplier do not match.']);
    }

    // Increase the product quantity
    $product->quantity += $request->quantity;
    $product->save();
    $total = $product->cost_price * $request->quantity;
$supplierName = $product->supplier ? $product->supplier->name : null;


    // Optionally, create an order record (if you want to track restocks)
    \App\Models\Order::create([
        'order_id' => 'SORD' . mt_rand(100000, 999999),
        'product_id' => $product->id,
        'supplier_code' => $request->supplier_code,
        'quantity' => $request->quantity,
        'supplier_name' => $supplierName, // <-- Add this line

        'total' => $total,
        'delivery_status' => 'pending',
        'order_date' => now(),
        'products' => json_encode([
        [
            'name' => $product->name,
            'quantity' => $request->quantity,
            'sku' => $product->sku,
        ]
    ]),
        //'delivery_status' => 'Restocked',
        // Add other fields as needed
    ]);

    return back()->with('success', 'Product restocked successfully!');
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

    if (!is_array($products)) {
        return redirect()->back()->withErrors(['products' => 'No products found in this order.']);
    }

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

public function reject($order_id)
{
    $order = Order::where('order_id', $order_id)->firstOrFail();
    $order->delivery_status = 'Rejected';
    $order->completed_date = now();
    $order->save();

    return redirect()->back()->with('success', 'Order has been rejected.');
}
   

public function uploadInvoice(Request $request, $order_id)
{
    $request->validate([
        'invoice_slip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Accepts PDF and images, max 2MB
    ]);

    $order = Order::where('order_id', $order_id)->firstOrFail();

    // Store the uploaded file
    $path = $request->file('invoice_slip')->store('invoices', 'public');

    // Save the invoice path to the order (use the correct column name)
    $order->invoice_slip = $path;
    $order->save();

    return redirect()->back()->with('success', 'Invoice uploaded successfully.');
}
}