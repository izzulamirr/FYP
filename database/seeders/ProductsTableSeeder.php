<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Food', 'Hardware', 'Stationery'];

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('products')->insert([
                    'sku' => strtoupper(Str::random(8)), // Random unique SKU
                    'name' => $category . ' Product ' . $i,
                    'quantity' => rand(10, 100), // Random quantity between 10 and 100
                    'price' => rand(100, 1000) / 10, // Random price between 10.0 and 100.0
                    'category' => $category,
                    'supplier_code' => rand(1, 5), // Assuming supplier IDs range from 1 to 5
                    'image' => 'products/' . strtolower($category) . '_product_' . $i . '.png', // Image path
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
// This seeder will create 10 products for each category with random SKUs, quantities, and prices.

