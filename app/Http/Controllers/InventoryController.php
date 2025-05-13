<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
   

    public function index()
    {
        // Retrieve the 10 most recently added products
    $products = Product::latest()->take(10)->get();
    
          // Fetch unique categories from the products table
    $categories = Product::select('category')->distinct()->pluck('category');



        // Pass the products to the view
        return view('System.Inventory', compact('products','categories'));
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

    

    public function create()
{

    // Fetch all unique categories
    $categories = Product::select('category')->distinct()->pluck('category');

   // If you need to pass additional data (e.g., categories or suppliers), fetch them here.
   $suppliers = Supplier::all(); // Assuming you have a Supplier model and table.

   // Return the Add Product view with suppliers
   return view('System.Products.add', compact('suppliers', 'categories'));

}


    public function edit($id)
{
    // Fetch the product to edit
    $product = Product::findOrFail($id);

    // Pass the product to the edit view
    return view('System.Products.edit', compact('product'));}

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

    ]);

    // Find the product and update its details
    $product = Product::findOrFail($id);
    $product->update($request->all());

    // Redirect back with a success message
    return redirect()->route('products.view', ['category' => $product->category])->with('success', 'Product updated successfully.');
}



public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'sku' => 'required|string|unique:products,sku',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'cost_price' => 'required|numeric|min:0',

            'price' => 'required|numeric',
            'category' => 'required|string',
            'supplier_code' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

         // Generate a unique barcode
    $barcode = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);

 $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

        // Create a new product
        Product::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'category' => $request->category,
          'barcode' => $barcode,

            'supplier_code' => $request->supplier_code,
        ]);

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