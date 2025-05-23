<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display all users
    public function index()
    {
        // Eager load the user-specific role
        $users = User::with('role.permissions')->get();
        return view('System.Staff', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,staff',
        ]);

        $user = User::findOrFail($id);

        // Update or create the user-specific role
        Role::updateOrCreate(
            ['user_id' => $user->id],
            ['name' => $request->role]
        );

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function permissions($id)
{
    $user = User::with('role.permissions')->findOrFail($id);
    $allPermissions =Permission::all();
    return view('System.Staff.permissions', compact('user', 'allPermissions'));
}

public function updatePermissions(Request $request, $id)
{
    $user = User::with('role')->findOrFail($id);
    $role = $user->role;
    if ($role) {
        $role->permissions()->sync($request->permissions ?? []);
    }
    return redirect()->route('staff.index')->with('success', 'Permissions updated.');
}

    public function create()
    {
        return view('System.Staff.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('System.Staff.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,staff',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        // Update or create the user-specific role
        Role::updateOrCreate(
            ['user_id' => $user->id],
            ['name' => $request->role]
        );

        return redirect()->route('Staff')->with('success', 'Staff updated successfully.');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Hash::make($request->password),
    ]);

    Role::create([
        'user_id' => $user->id,
        'name' => $request->role,
    ]);

    return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Optionally delete the user's role as well
        Role::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted.');    }
}