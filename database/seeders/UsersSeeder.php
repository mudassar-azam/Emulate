<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'buyer',
                'email' => 'buyer@example.com',
                'role' => 'buyer',
                'password' => Hash::make('password'), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'creater',
                'email' => 'creater@example.com',
                'role' => 'seller',
                'password' => Hash::make('password'), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'creater1',
                'email' => 'creater1@example.com',
                'role' => 'seller',
                'password' => Hash::make('password'), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'creater2',
                'email' => 'creater2@example.com',
                'role' => 'seller',
                'password' => Hash::make('password'), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'creater3',
                'email' => 'creater3@example.com',
                'role' => 'seller',
                'password' => Hash::make('password'), 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
