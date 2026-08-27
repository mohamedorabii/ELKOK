<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            [
                'name_en' => '39',
                'name_ar' => '39',
                'status' => 1,
            ],
            [
                'name_en' => '40',
                'name_ar' => '40',
                'status' => 1,
            ],
            [
                'name_en' => '41',
                'name_ar' => '41',
                'status' => 1,
            ],
            [
                'name_en' => '42',
                'name_ar' => '42',
                'status' => 1,
            ],
            [
                'name_en' => '43',
                'name_ar' => '43',
                'status' => 1,
            ],
            [
                'name_en' => '44',
                'name_ar' => '44',
                'status' => 1,
            ],
            [
                'name_en' => '45',
                'name_ar' => '45',
                'status' => 1,
            ],
            [
                'name_en' => '46',
                'name_ar' => '46',
                'status' => 1,
            ],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(
                ['name_en' => $size['name_en']],
                $size
            );
        }
    }
}