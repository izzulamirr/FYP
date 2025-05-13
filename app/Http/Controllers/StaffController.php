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

    public function create()
{
    // Return the view for creating a new staff member
    return view('System.Staff.create');
}

    public function edit($id)
{
    // Fetch the staff member by ID
    $user = User::findOrFail($id);

    // Return the edit view with the user data
    return view('System.Staff.edit', compact('user'));
}

public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string|in:admin,staff',
    ]);

    // Find the user and update their details
    $user = User::findOrFail($id);
    $user->update($request->only('name', 'email', 'role'));

    // Redirect back with a success message
    return redirect()->route('Staff')->with('success', 'Staff updated successfully.');
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