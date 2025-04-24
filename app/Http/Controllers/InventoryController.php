<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
   

    public function index()
    {
        // Retrieve all products from the database
        $products = Product::all();

          // Fetch unique categories from the products table
    $categories = Product::select('category')->distinct()->pluck('category');

        // Pass the products to the view
        return view('System.Inventory', compact('products','categories'));
    }

    public function list($category)
{   
    // Fetch products for the selected category
    $products = Product::where('category', $category)->get();

   
    // Pass the products and category to the view
    return view('System.Products.viewProducts', compact('products', 'category'));
}


    

    public function create()
    {
        // Return the Add Product view
        return view('System.Products.add');

          // Return the Add Product view with suppliers
    return view('System.Products.add', compact('suppliers'));
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
        $request->validate([
            'sku' => 'required|string|unique:products,sku',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'supplier_code' => 'required|string|max:255',
        ]);

        // Create a new product
        Product::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'category' => $request->category,
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

   
}