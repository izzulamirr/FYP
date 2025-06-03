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
 //$this->call([
   //     TransactionSeeder::class,
    //]);

    $this->call([
    SupplierSeeder::class,
    // other seeders...
]);
        
    }
}