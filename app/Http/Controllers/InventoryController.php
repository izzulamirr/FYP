<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
{
    $categories = \App\Models\Product::distinct()->pluck('category');
    $query = \App\Models\Product::query();

    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    $products = $query->get();

// In your controller
    $recentProducts = Product::orderBy('created_at', 'desc')->take(10)->get();

    return view('System.Inventory', compact('categories', 'products', 'recentProducts'));
}

    public function list(Request $request)
    {
        $category = $request->get('category'); // Get the selected category from the request
        $categories = Product::select('category')->distinct()->pluck('category'); // Fetch all unique categories

        // Filter products by category if a category is selected
        $products = $category
            ? Product::where('category', $category)->paginate(10)->appends(['category' => $category]) // Append category to pagination links
            : Product::paginate(10);

        return view('System.Products.viewProducts', compact('products', 'category', 'categories'));
    }

    // Show the form to create a new product
    public function create()
    {

        $suppliers = Supplier::all();

        // Generate a unique SKU
    $sku = 'PD'  . mt_rand(10000, 99999);

        // Fetch any necessary data for the form (e.g., categories, suppliers)
        $categories = Product::select('category')->distinct()->pluck('category');
       
        // Return the view for creating a product
        return view('System.Products.add', compact('categories','suppliers','sku'));
    }

    public function edit($id)
    {
        // Fetch the product to edit
        $product = Product::findOrFail($id);

        // Pass the product to the edit view
        return view('System.Products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'cost_price' => 'required|numeric',
            'price' => 'required|numeric',
            'category' => 'required',
            'barcode' => 'nullable|string|unique:products,barcode,' . $id, // Allow updating barcode
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        // Find the product and update its details
        $product = Product::findOrFail($id);
       // Find the product and update its details
    $product = Product::findOrFail($id);

    $product->name = $request->name;
    $product->quantity = $request->quantity;
    $product->cost_price = $request->cost_price;
    $product->price = $request->price;
    $product->category = $request->category;
    $product->barcode = $request->barcode; // This will keep or update the barcode

    $product->save();

    // Redirect back with a success message
    return redirect()->route('products.view', ['category' => $product->category])
        ->with('success', 'Product updated successfully.');
}

    // Store a new product in the database
   public function store(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'sku' => 'required|string|unique:products,sku',
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'cost_price' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'supplier_code' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    ]);

    // Handle the image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    // Generate a unique barcode
    $barcode = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);

      // Find the supplier by supplier_code
    $supplier = Supplier::where('supplier_code', $validated['supplier_code'])->first();

    // If the supplier does not exist, return an error
    if (!$supplier) {
        return redirect()->back()->withErrors(['supplier_code' => 'Supplier with the given code does not exist.']);
    }

    

    // Save the product to the database
    Product::create([
        'sku' => $validated['sku'], // Use the SKU from the form
        'name' => $validated['name'],
        'quantity' => $validated['quantity'],
        'cost_price' => $validated['cost_price'],
        'price' => $validated['price'],
        'category' => $validated['category'],
        'supplier_code' => $supplier->supplier_code, // Use supplier_id instead of supplier_code
        'image' => $imagePath,
        'barcode' => $barcode, // Save the generated barcode
    ]);

    // Redirect back with a success message
   // return redirect()->route('products.list')->with('success', 'Product added successfully.');
   
// Redirect back with a success message
return redirect()->route('inventory.index')->with('success', 'Product added successfully.');

}
    public function destroy($id)
    {
        // Fetch the product to delete
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function getProductByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'cost_price' => $product->cost_price,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'barcode' => $product->barcode,
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found!']);
    }

    public function processTransaction(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);

            if ($product->quantity < $productData['quantity']) {
                return response()->json(['success' => false, 'message' => "Not enough stock for product: {$product->name}"]);
            }

            $product->quantity -= $productData['quantity'];
            $product->save();
        }

        return response()->json(['success' => true, 'message' => 'Transaction completed successfully!']);
    }
}