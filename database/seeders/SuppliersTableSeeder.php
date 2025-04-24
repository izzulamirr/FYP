<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Seed suppliers based on the provided IDs
        $suppliers = [
            ['id' => 1, 'name' => 'Supplier 1', 'phone' => '123-456-7891', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Supplier 2', 'phone' => '123-456-7892', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Supplier 3', 'phone' => '123-456-7893', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Supplier 4', 'phone' => '123-456-7894', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Supplier 5', 'phone' => '123-456-7895', 'created_at' => now(), 'updated_at' => now()],
        ];

          // Insert suppliers into the database
          DB::table('suppliers')->insert($suppliers);
    }

      
    }

