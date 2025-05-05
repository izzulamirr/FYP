<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order; // Assuming you have an Order model
use App\Models\Supplier; // Assuming you have a Supplier model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function index()
    {  
            // Fetch all orders from the database
            $orders = Order::all();
    
            // Pass the orders to the view
            return view('System.Supplies', compact('orders'));
        
    }

    public function create()
    {
        return view('System.StaffCreate'); // View for adding new staff
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff', // Assign the role as 'staff'
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch the staff by ID
        return view('System.StaffEdit', compact('user')); // View for editing staff
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}