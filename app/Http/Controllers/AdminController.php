<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Return the admin dashboard view
        return view('admin.dashboard');
    }

    public function assignDefaultPermissions()
{
    $adminRole = \App\Models\Role::where('name', 'admin')->first();
    $staffRole = \App\Models\Role::where('name', 'staff')->first();

    $create = \App\Models\Permission::where('Description', 'Create')->first();
    $update = \App\Models\Permission::where('Description', 'Update')->first();
    $restock = \App\Models\Permission::where('Description', 'Restock')->first();

    if ($adminRole && $create && $update && $restock) {
        $adminRole->permissions()->sync([
            $create->PermissionID,
            $update->PermissionID,
            $restock->PermissionID
        ]);
    }

    if ($staffRole && $create) {
        $staffRole->permissions()->sync([
            $create->PermissionID
        ]);
    }

    return redirect()->back()->with('success', 'Default permissions assigned to roles.');
}
}
