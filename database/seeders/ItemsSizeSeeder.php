<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ItemsSizeSeeder extends Seeder
{
    public function run()
    {
        DB::table('item_sizes')->insert([
            ['size_id' => 1, 'item_id' => 1, 'quantity' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 6, 'item_id' => 1, 'quantity' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 2, 'item_id' => 2, 'quantity' => 30, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 7, 'item_id' => 2, 'quantity' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 3, 'item_id' => 3, 'quantity' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 1, 'item_id' => 3, 'quantity' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 4, 'item_id' => 4, 'quantity' => 25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 2, 'item_id' => 4, 'quantity' => 25, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 5, 'item_id' => 5, 'quantity' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size_id' => 3, 'item_id' => 5, 'quantity' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
