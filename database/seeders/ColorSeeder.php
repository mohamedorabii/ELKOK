<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            [
                'name_en' => 'Black',
                'name_ar' => 'أسود',
                'hex_code' => '#000000',
                'status' => 1,
            ],
            [
                'name_en' => 'White',
                'name_ar' => 'أبيض',
                'hex_code' => '#FFFFFF',
                'status' => 1,
            ],
            [
                'name_en' => 'Grey',
                'name_ar' => 'رمادي',
                'hex_code' => '#808080',
                'status' => 1,
            ],
            [
                'name_en' => 'Red',
                'name_ar' => 'أحمر',
                'hex_code' => '#FF0000',
                'status' => 1,
            ],
            [
                'name_en' => 'Blue',
                'name_ar' => 'أزرق',
                'hex_code' => '#0000FF',
                'status' => 1,
            ],
            [
                'name_en' => 'Green',
                'name_ar' => 'أخضر',
                'hex_code' => '#008000',
                'status' => 1,
            ],
            [
                'name_en' => 'Beige',
                'name_ar' => 'بيج',
                'hex_code' => '#F5F5DC',
                'status' => 1,
            ],
        ];

        foreach ($colors as $color) {
            Color::updateOrCreate(
                ['name_en' => $color['name_en']],
                $color
            );
        }
    }
}