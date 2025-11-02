<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodsTableSeeder extends Seeder
{
    public function run(): void
    {
        Food::create([
            'restaurant_id' => 2,
            'name' => 'كباب مشوي',
            'description' => 'كباب لحم مشوي على الفحم',
            'price' => 50.00,
            'image' => 'https://example.com/images/kebab.jpg'
        ]);

        Food::create([
            'restaurant_id' => 2,
            'name' => 'فتة حمص',
            'description' => 'فتة حمص مع صلصة طحينة طازجة',
            'price' => 30.00,
            'image' => 'https://example.com/images/fatteh.jpg'
        ]);
    }
}
