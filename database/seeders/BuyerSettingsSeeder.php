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
            'gender' => 'male', 
            'user_id' => 2, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
