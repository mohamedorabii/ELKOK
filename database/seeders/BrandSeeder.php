<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name_en' => 'Nike',
                'name_ar' => 'نايك',
                'image' => 'brands/nike.jpg',
                'image_url' => 'https://loremflickr.com/800/500/nike,shoes?lock=301',
                'status' => 1,
            ],
            [
                'name_en' => 'Adidas',
                'name_ar' => 'أديداس',
                'image' => 'brands/adidas.jpg',
                'image_url' => 'https://loremflickr.com/800/500/adidas,shoes?lock=302',
                'status' => 1,
            ],
            [
                'name_en' => 'Puma',
                'name_ar' => 'بوما',
                'image' => 'brands/puma.jpg',
                'image_url' => 'https://loremflickr.com/800/500/puma,shoes?lock=303',
                'status' => 1,
            ],
            [
                'name_en' => 'Skechers',
                'name_ar' => 'سكيتشرز',
                'image' => 'brands/skechers.jpg',
                'image_url' => 'https://loremflickr.com/800/500/skechers,shoes?lock=304',
                'status' => 1,
            ],
            [
                'name_en' => 'New Balance',
                'name_ar' => 'نيو بالانس',
                'image' => 'brands/new-balance.jpg',
                'image_url' => 'https://loremflickr.com/800/500/newbalance,shoes?lock=305',
                'status' => 1,
            ],
            [
                'name_en' => 'Fila',
                'name_ar' => 'فيلا',
                'image' => 'brands/fila.jpg',
                'image_url' => 'https://loremflickr.com/800/500/fila,shoes?lock=306',
                'status' => 1,
            ],
        ];

        Storage::disk('public')->makeDirectory('brands');

        foreach ($brands as $item) {

            $imagePath = $item['image'];

            if (!Storage::disk('public')->exists($imagePath)) {
                try {
                    $response = Http::timeout(30)
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0',
                        ])
                        ->get($item['image_url']);

                    if ($response->successful()) {

                        Storage::disk('public')->put(
                            $imagePath,
                            $response->body()
                        );

                        $this->command?->info(
                            "✓ Brand image downloaded: {$item['name_en']}"
                        );

                    } else {
                        $this->command?->warn(
                            "⚠ Failed image: {$item['name_en']}"
                        );
                    }

                } catch (\Throwable $e) {

                    $this->command?->warn(
                        "⚠ Image error: {$item['name_en']} - {$e->getMessage()}"
                    );
                }
            }

            Brand::updateOrCreate(
                [
                    'name_en' => $item['name_en'],
                ],
                [
                    'name_ar' => $item['name_ar'],
                    'image' => $item['image'],
                    'status' => $item['status'],
                ]
            );
        }
    }
}