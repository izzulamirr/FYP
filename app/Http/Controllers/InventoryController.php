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

        // Pass the products to the view
        return view('System.Inventory', compact('products'));
    }


    public function create()
    {
        // Return the Add Product view
        return view('System.Products.add');

          // Return the Add Product view with suppliers
    return view('System.Products.add', compact('suppliers'));
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

   
}