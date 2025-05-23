<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order; // Assuming you have an Order model
use App\Models\Supplier; // Assuming you have a Supplier model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuppliersController extends Controller
{
    /**
     * Display the suppliers dashboard.
     */
    public function dashboard()
    {
        // Fetch all suppliers
    $suppliers = Supplier::with('products')->get();

    // Calculate statistics
    $totalSuppliers = $suppliers->count();
    $activeSuppliers = $suppliers->filter(function ($supplier) {
        return $supplier->products->isNotEmpty();
    })->count();
    $inactiveSuppliers = $totalSuppliers - $activeSuppliers;

    // Pass data to the view
    return view('System.Supplies.dashboard', compact('suppliers', 'totalSuppliers', 'activeSuppliers', 'inactiveSuppliers'));
    }

    /**
     * Display all orders.
     */
   

public function create()
{
    // Return the view for creating a new supplier
    return view('System.Supplies.add');
}

public function store(Request $request)
{
    // Validate the request
     $request->validate([
        'supplier_code' => 'required|string|max:255|unique:suppliers,supplier_code',
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255|unique:suppliers,email', // Email is optional
        'phone' => 'nullable|string|max:15', // Phone is optional
    ]);

    // Create a new supplier
     Supplier::create([
        'supplier_code' => $request->supplier_code,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    // Redirect back to the dashboard with a success message
    return redirect()->route('suppliers.dashboard')->with('success', 'Supplier added successfully.');
}

public function edit($supplier_code)
{
    // Find the supplier by supplier_code
    $supplier = Supplier::where('supplier_code', $supplier_code)->firstOrFail();

    // Return the edit view with the supplier data
    return view('System.Supplies.edit', compact('supplier'));
}

public function update(Request $request, $supplier_code)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:15',
    ]);

    // Find the supplier by supplier_code
    $supplier = Supplier::where('supplier_code', $supplier_code)->firstOrFail();

    // Update the supplier
    $supplier->update($request->only('name', 'email', 'phone'));

    // Redirect back with a success message
   return redirect()->route('suppliers.dashboard')->with('success', 'Supplier update successfully.');
}

public function destroy($supplier_code)
{
    // Find the supplier by supplier_code
    $supplier = Supplier::where('supplier_code', $supplier_code)->firstOrFail();

    // Delete the supplier
    $supplier->delete();

    // Redirect back to the dashboard with a success message
    return redirect()->route('suppliers.dashboard')->with('success', 'Supplier deleted successfully.');
}






}