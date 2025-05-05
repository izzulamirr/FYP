<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'staff')->get(); // Fetch only staff users
        return view('System.Staff', compact('users'));
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