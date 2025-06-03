<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier; // Import the Supplier model
use Illuminate\Support\Facades\DB;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $suppliers = [
        [
            'supplier_code' => 'SP1001',
            'name' => 'EcoShop Supplies',
            'email' => 'contact@ecoshop.com',
            'phone' => '03-1111 2222',
        ],
        [
            'supplier_code' => 'SP1002',
            'name' => 'TechnoMart',
            'email' => 'sales@technomart.com',
            'phone' => '03-2222 3333',
        ],
        [
            'supplier_code' => 'SP1003',
            'name' => 'GreenGrocer',
            'email' => 'info@greengrocer.com',
            'phone' => '03-3333 4444',
        ],
        [
            'supplier_code' => 'SP1004',
            'name' => 'Stationery World',
            'email' => 'hello@stationeryworld.com',
            'phone' => '03-4444 5555',
        ],
        [
            'supplier_code' => 'SP1005',
            'name' => 'HealthPlus Pharma',
            'email' => 'support@healthplus.com',
            'phone' => '03-5555 6666',
        ],
    ];

    foreach ($suppliers as $supplier) {
        DB::table('suppliers')->insert([
            'supplier_code' => $supplier['supplier_code'],
            'name' => $supplier['name'],
            'email' => $supplier['email'],
            'phone' => $supplier['phone'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    }
    }

