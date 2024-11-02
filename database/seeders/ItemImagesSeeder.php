<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller\ItemImage;

class ItemImagesSeeder extends Seeder
{
    public function run()
    {
        $imageNames = [
            '1728438048_6705df209a184_1.jfif',
            '17302077346720dff61edc1priscilla-du-preez-dlxLGIy-2VU-unsplash.jpg',
            '1728438048_6705df209a184_3.jfif',
            '1728438048_6705df209a184_4.jfif',
            '1728438048_6705df209a184_5.jfif',
        ];
        
        $itemIds = [1, 2, 3, 4, 5];
        
        foreach ($itemIds as $key => $itemId) {
            ItemImage::create([
                'item_id' => $itemId,
                'image_name' => $imageNames[$key], 
            ]);
        }
    }
}
