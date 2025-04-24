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

}