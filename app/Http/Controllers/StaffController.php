<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display all staff users
    public function index()
    {
        $users = User::where('role', 'staff')->get(); // Fetch only staff users
        return view('System.Staff', compact('users'));
    }

    // Show the form for creating a new staff member
    public function create()
    {
        return view('System.StaffCreate'); // View for adding new staff
    }

    // Store a new staff member
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user with the 'staff' role
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff', // Assign the role as 'staff'
        ]);

        // Redirect back with a success message
        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
    }

    // Show the form for editing a staff member
    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch the staff by ID
        return view('System.StaffEdit', compact('user')); // View for editing staff
    }

    // Update a staff member
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Update the user's information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redirect back with a success message
        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    // Delete a staff member
    public function destroy($id)
    {
        // Find the user by ID and delete them
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}