<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantsTableSeeder extends Seeder
{
    public function run(): void
    {
        Restaurant::create([
            'owner_id' => 1,
            'name' => 'مطعم النخيل',
            'description' => 'مطعم يقدم أكل شرقي أصيل',
            'image' => 'https://example.com/images/nakheel.jpg',
            'location' => 'اسطنبول - الفاتح',
        ]);

        Restaurant::create([
            'owner_id' => 1,
            'name' => 'مطعم الفيروز',
            'description' => 'أطباق لبنانية متنوعة',
            'image' => 'https://example.com/images/fayrouz.jpg',
            'location' => 'اسطنبول - السلطان أحمد',
        ]);
    }
}
