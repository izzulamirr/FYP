<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier; // Import the Supplier model


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert([
            [
                'id' => 'SUP001',
                'name' => 'Tech Supplies Inc.',
                'email' => 'techsupplies@Gmail.com',
                'phone' => '123-456-7890',
            ],
            [
                'id' => 'SUP002',
                'name' => 'Mobile World',
                'email' => 'mobileworld@Gmail.com',
                'phone' => '987-654-3210',
            ],
            [
                'id' => 'SUP003',
                'name' => 'Hardware Depot',
                'email' => 'hardwaredepot@Gmail.com',
                'phone' => '555-123-4567',
            ],
            [
                'id' => 'SUP004',
                'name' => 'Stationery Hub',
                'email' => 'stationeryhub@gmail.com',
                'phone' => '444-987-6543',
            ],
            [
                'id' => 'SUP005',
                'name' => 'Beverage Supplies Co.',
                'email' => 'beverages@gmail.com',
                'phone' => '333-222-1111',
            ],
        ]);
    }
    }

