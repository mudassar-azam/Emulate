<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => 'Item 1',
                'rental_price' => 29.99,
                'sale_price' => 29.99,
                'user_id' => 3,
                'category_id' => 1,
                'stock' => 10,
                'description' => "Description of product 1",
                'item_type' => 'for_rent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Item 2',
                'rental_price' => 29.99,
                'sale_price' => 29.99,
                'user_id' => 3,
                'category_id' => 2,
                'stock' => 10,
                'description' => "Description of product 2",
                'item_type' => 'for_rent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Item 3',
                'rental_price' => 29.99,
                'sale_price' => 29.99,
                'user_id' => 4,
                'category_id' => 3,
                'stock' => 10,
                'description' => "Description of product 3",
                'item_type' => 'for_sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Item 4',
                'rental_price' => 29.99,
                'sale_price' => 29.99,
                'user_id' => 4,
                'category_id' => 4,
                'stock' => 10,
                'description' => "Description of product 4",
                'item_type' => 'for_sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Item 5',
                'rental_price' => 29.99,
                'sale_price' => 29.99,
                'user_id' => 5,
                'category_id' => 5,
                'stock' => 10,
                'description' => "Description of product 5",
                'item_type' => 'for_sale',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
