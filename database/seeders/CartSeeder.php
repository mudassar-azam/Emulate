<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{

    public function run()
    {
        DB::table('carts')->insert([
            [
                'product_id' => rand(1, 5),
                'user_id' => 2,
                'size_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => rand(1, 5),
                'user_id' => 2,
                'size_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
