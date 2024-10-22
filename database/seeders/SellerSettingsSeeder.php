<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('seller_settings')->insert([
            [
                'introduction' => 'Introduction for user 1',
                'facebook_link' => null,
                'youtube_link' => null,
                'instagram_link' => null,
                'twitter_link' => null,
                'profile' => '1728439195_6705e39b328c4_1.jpg',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'introduction' => 'Introduction for user 2',
                'facebook_link' => null,
                'youtube_link' => null,
                'instagram_link' => null,
                'twitter_link' => null,
                'profile' => '1728439195_6705e39b328c4_2.jpg',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'introduction' => 'Introduction for user 3',
                'facebook_link' => null,
                'youtube_link' => null,
                'instagram_link' => null,
                'twitter_link' => null,
                'profile' => '1728439195_6705e39b328c4_3.jpg',
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'introduction' => 'Introduction for user 3',
                'facebook_link' => null,
                'youtube_link' => null,
                'instagram_link' => null,
                'twitter_link' => null,
                'profile' => '1728439195_6705e39b328c4_4.jpg',
                'user_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
