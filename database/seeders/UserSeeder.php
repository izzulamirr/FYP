<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'Zakwan Staff',
            'email' => 'cleanoxmy@gmail.com',
            'password' => bcrypt('James@555'), // Replace 'password' with a secure password
            'role' => 'staff',
        ]);
    }
}