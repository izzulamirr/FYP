<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    // Show the inventory dashboard with category filtering
    public function index(Request $request)
    {
        // Get category from query string, default to 'all'
        $category = $request->query('category', 'all');

        // Start query builder
        $query = Product::query();

        // Apply category filter if not 'all'
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // Get sorted products
        $products = $query->orderBy('name', 'asc')->get();

        // Pass products and category to the view
        return view('inventory', [
            'products' => $products,
            'category' => $category
        ]);
    }

    // Handle new product submissions
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Food,Hardware,Electronics,Stationery',
            'supplier_code' => 'required|string|max:100',
        ]);

        // Create the product
        Product::create($request->all());

        // Redirect back with success message
        return redirect()->route('inventory.index')->with('success', "Product '{$request->name}' added successfully!");
    }
}
