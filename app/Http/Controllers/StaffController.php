<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming staff are stored in the User model
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display all users
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Pass the users to the view
        return view('System.Staff', compact('users'));
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
            'role' => 'user', // Default role for new staff
        ]);

        // Redirect back with a success message
        return redirect()->route('Staff')->with('success', 'Staff member added successfully.');
    }

    // Delete a staff member
    public function destroy($id)
    {
        // Find the user by ID and delete them
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('Staff')->with('success', 'Staff member deleted successfully.');
    }
}