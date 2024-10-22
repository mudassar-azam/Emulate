<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller\Post;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            ['post' => 'First post for item 1', 'item_id' => 1 , 'user_id' => 3],
            ['post' => 'Second post for item 2', 'item_id' => 2 , 'user_id' => 3],
            ['post' => 'Third post for item 3', 'item_id' => 3 , 'user_id' => 3],
            ['post' => 'Fourth post for item 4', 'item_id' => 4 , 'user_id' => 3],
            ['post' => 'Fifth post for item 5', 'item_id' => 5 , 'user_id' => 3],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
