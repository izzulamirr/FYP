<?php

namespace App\Http\Controllers;

use App\Models\Supplier; // Import the Supplier model
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
/**
     * Display the suppliers page.
     */
    public function index()
    {
        // Fetch all suppliers from the database
        $suppliers = Supplier::all();

        // Pass the suppliers to the view
        return view('System.Supplies', compact('suppliers'));
    }
}
