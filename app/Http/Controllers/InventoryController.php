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
 // Get the selected category from the request
 $category = $request->get('category');

 // Fetch all unique categories
 $categories = Product::select('category')->distinct()->pluck('category');

 // Fetch products for the selected category, or all products if no category is specified
 $products = $category 
     ? Product::where('category', $category)->get()
     : Product::all();

 // Pass the products and categories to the view
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
        'price' => 'required|numeric',
        'category' => 'required',
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
    $validated = $request->validate([
        'sku' => 'required|string|unique:products,sku',
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'category' => 'required|string|max:255',
        'supplier_code' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    \Log::info('Validation Passed:', $validated);

    // Handle the image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        \Log::info('Image Path:', [$imagePath]);
    }

    // Save the product
    $product = Product::create([
        'sku' => $request->sku,
        'name' => $request->name,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'category' => $request->category,
        'supplier_code' => $request->supplier_code,
        'image' => $imagePath,
    ]);
   
    return redirect()->route('products.create')->with('success', 'Product added successfully.');
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

   
}