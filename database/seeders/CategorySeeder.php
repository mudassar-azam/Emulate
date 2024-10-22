<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run()
    {
        $categories = [
            'Accessories',
            'Activewear',
            'Bags and Hand Bags',
            'Blazers',
            'Costumes',
            'Dresses',
            'Jackets',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
