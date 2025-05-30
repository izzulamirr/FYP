<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    // Seed roles
Role::firstOrCreate(['name' => 'admin']);
Role::firstOrCreate(['name' => 'manager']);
Role::firstOrCreate(['name' => 'staff']);

        
DB::table('role_user')->insert([
    'user_id' => 11,
    'role_id' => 10, // Use the correct RoleID from your roles table
]);
        
    }
}