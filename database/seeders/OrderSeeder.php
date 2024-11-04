<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrderSeeder extends Seeder
{
    public function run()
    {
        $orders = [
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => null,
                'start_date' => null,
                'end_date' => null,
                'type' => 'cart',
                'size_id' => 1,
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => null,
                'start_date' => null,
                'end_date' => null,
                'type' => 'cart',
                'size_id' => 2,
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => '1 day',
                'start_date' => '2024-01-01',
                'end_date' => '2024-02-01',
                'type' => 'rent',
                'size_id' => 3,
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => '5 days',
                'start_date' => '2024-01-01',
                'end_date' => '2024-07-01',
                'type' => 'rent',
                'size_id' => 4,
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => null,
                'start_date' => null,
                'end_date' => null,
                'type' => 'buy',
                'size_id' => 5,
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
            [
                'user_id' => 2,
                'product_id' => rand(1, 5),
                'product_owner_id' => rand(3, 6),
                'lease_term' => null,
                'start_date' => null,
                'end_date' => null,
                'size_id' => 5,
                'type' => 'buy',
                'total_payment' => '100',
                'payment_status' => 'due',
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
