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
            ['id' => 18, 'name' => 'Earbuds', 'price' => 40.00],
            ['id' => 20, 'name' => 'Screw Driver Set', 'price' => 30.00],
            // Add more products as needed
        ];

        for ($i = 0; $i < 30; $i++) {
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
                'created_at' => $now->copy()->subDays(rand(0, 180)),
                'updated_at' => $now,
            ]);
        }
    }
}