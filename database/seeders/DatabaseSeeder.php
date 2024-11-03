<?php

namespace Database\Seeders;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(SellerSettingsSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(BuyerSettingsSeeder::class);
        $this->call(ItemImagesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(PostImagesSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ItemsSizeSeeder::class);
    }
}
