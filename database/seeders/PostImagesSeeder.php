<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller\PostImage;

class PostImagesSeeder extends Seeder
{
    public function run()
    {
        $imageNames = [
            '1728438951_6705e2a79d47c_1.jpg',
            '1728438951_6705e2a79d47c_2.jpg',
            '1728438951_6705e2a79d47c_3.jpg',
            '1728438951_6705e2a79d47c_4.jpg',
            '1728438951_6705e2a79d47c_5.jpg',
        ];
    
        $postIds = [1, 2, 3, 4, 5];
    
        foreach ($postIds as $key => $postId) {
            PostImage::create([
                'post_id' => $postId,
                'image_name' => $imageNames[$key],
            ]);
        }
    }
    
}
