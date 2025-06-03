<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $faker = \Faker\Factory::create();

        $paymentMethods = ['Cash', 'Credit Card', 'Online Banking', 'Ewallet'];
        $productsList = [
               ['id' => 10, 'name' => 'Koko Crunch 300g', 'price' => 14.50],
            ['id' => 11, 'name' => 'Milo Original 240ml', 'price' => 3.00],
            ['id' => 12, 'name' => 'Kit Kat', 'price' => 3.00],
            ['id' => 13, 'name' => 'Nescafe 240ml', 'price' => 3.50],
            ['id' => 14, 'name' => 'Cable Type C', 'price' => 12.00],
            ['id' => 18, 'name' => 'Earbuds', 'price' => 40.00],
            ['id' => 19, 'name' => 'Faber-Castel Pen', 'price' => 3.00],
            ['id' => 20, 'name' => 'Screw Driver Set', 'price' => 30.00],
            ['id' => 21, 'name' => 'Colgate 200g', 'price' => 7.00],
            ['id' => 24, 'name' => 'Pendrive 32gb', 'price' => 12.50],
            ['id' => 25, 'name' => 'Mouse', 'price' => 15.00],
            ['id' => 26, 'name' => 'Tissue Premier', 'price' => 5.00],
            ['id' => 27, 'name' => 'Yakult Original', 'price' => 2.50],
            ['id' => 28, 'name' => "Yeo's Chrysanthemum Tea", 'price' => 2.50],
            ['id' => 29, 'name' => 'Mr Potato Barbeque Flavour', 'price' => 4.00],
            ['id' => 30, 'name' => 'KitKat Chunky', 'price' => 3.50],
            ['id' => 31, 'name' => 'Abacus', 'price' => 20.00],
            ['id' => 32, 'name' => 'Casio Calculator', 'price' => 30.00],
            ['id' => 33, 'name' => 'Fabel - Castel Sharpner', 'price' => 2.00],
            ['id' => 34, 'name' => 'Darlie Toothbrush', 'price' => 3.50],
            ['id' => 35, 'name' => 'Pantene Shampoo', 'price' => 12.00],
            ['id' => 36, 'name' => 'Electric Fan', 'price' => 20.00],
            ['id' => 37, 'name' => 'Extension Plug', 'price' => 8.00],
        ];

for ($i = 0; $i < 15; $i++) {
    $product = $faker->randomElement($productsList);
    $quantity = $faker->numberBetween(1, 5);
    $total_price = $product['price'] * $quantity;

    DB::table('transactions')->insert([
        'purchase_id' => 'PUR' . Str::random(12),
        'products' => json_encode([
            [
                'id' => $product['id'],
                'quantity' => $quantity,
                'name' => $product['name'],
                'price' => $product['price'],
            ]
        ]),
        'quantity' => $quantity,
        'total_price' => $total_price,
        'payment_method' => $faker->randomElement($paymentMethods),
        'payment_time' => null,
        // Set created_at to a random day in the current month
        'created_at' => $now->copy()->startOfMonth()->addDays(rand(0, $now->copy()->daysInMonth - 1))->setTime(rand(8, 20), rand(0, 59)),
        'updated_at' => $now,
    ]);
}
    }
}