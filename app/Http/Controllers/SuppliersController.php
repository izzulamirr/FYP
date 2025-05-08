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
        $totalSuppliers = Supplier::count(); // Count total suppliers
        $pendingPayments = Order::where('payment_status', 'pending')->count(); // Count pending payments
        $pendingDeliveries = Order::where('delivery_status', 'pending')->count(); // Count pending deliveries

        $suppliers = Supplier::all(); // Fetch all suppliers

        // Pass data to the view
        return view('System.Supplies.dashboard', compact('totalSuppliers', 'pendingPayments', 'pendingDeliveries', 'suppliers'));
    }

    /**
     * Display all orders.
     */
    public function ordersIndex()
    {
        // Fetch all orders from the database
        $orders = Order::all();

        // Pass the orders to the view
        return view('System.Supplies', compact('orders'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function createStaff()
    {
        return view('System.StaffCreate'); // View for adding new staff
    }

    /**
     * Store a newly created staff member in the database.
     */
    public function storeStaff(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Create a new staff user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff', // Assign the role as 'staff'
        ]);

        // Redirect to the staff index page with a success message
        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
    }

    /**
     * Show the form for editing a staff member.
     */
    public function editStaff($id)
    {
        // Fetch the staff by ID
        $user = User::findOrFail($id);

        // Return the view for editing staff
        return view('System.StaffEdit', compact('user'));
    }

    /**
     * Update the specified staff member in the database.
     */
    public function updateStaff(Request $request, $id)
    {
        // Fetch the staff by ID
        $user = User::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Update the staff details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redirect to the staff index page with a success message
        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified staff member from the database.
     */
    public function destroyStaff($id)
    {
        // Fetch the staff by ID
        $user = User::findOrFail($id);

        // Delete the staff member
        $user->delete();

        // Redirect to the staff index page with a success message
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}