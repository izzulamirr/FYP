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