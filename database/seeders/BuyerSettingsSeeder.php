<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuyerSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buyer_settings')->insert([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'dob' => '1990-01-01', 
            'number' => '1234567890', 
            'zipcode' => '12345', 
            'user_id' => 2, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
