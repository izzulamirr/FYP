<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions (avoid duplicates)
        $create = Permission::firstOrCreate(['Description' => 'Create']);
        $update = Permission::firstOrCreate(['Description' => 'Update']);
        $restock = Permission::firstOrCreate(['Description' => 'Restock']);

        // Create users (avoid duplicates)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Staff User', 'password' => bcrypt('password')]
        );

        // Create user-specific roles (avoid duplicates)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'user_id' => $adminUser->id]
        );
        $staffRole = Role::firstOrCreate(
            ['name' => 'staff', 'user_id' => $staffUser->id]
        );

        // Assign permissions to roles
        $adminRole->permissions()->sync([
            $create->PermissionID,
            $update->PermissionID,
            $restock->PermissionID
        ]);

        $staffRole->permissions()->sync([
            $create->PermissionID
        ]);
    }
}