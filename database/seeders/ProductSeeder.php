<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
          
            [
                'sku' => 'P003',
                'name' => 'Hammer',
                'quantity' => 25,
                'price' => 15.00,
                'category' => 'Hardware',
                'supplier_code' => 'SUP003',
            ],
            [
                'sku' => 'P004',
                'name' => 'Notebook',
                'quantity' => 50,
                'price' => 2.50,
                'category' => 'Stationery',
                'supplier_code' => 'SUP004',
            ],
            [
                'sku' => 'P005',
                'name' => 'Mineral Water',
                'quantity' => 30,
                'price' => 35.00,
                'category' => 'Consumables',
                'supplier_code' => 'SUP005',
            ],
        ]);
    }
}

