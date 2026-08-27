<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [
            // Sneakers
            [
                'category' => 'Sneakers',
                'name_en' => 'Men',
                'name_ar' => 'رجالي',
                'image' => 'subcategories/sneakers-men.jpg',
                'image_url' => 'https://loremflickr.com/900/600/mens,sneakers?lock=201',
                'status' => 1,
            ],
            [
                'category' => 'Sneakers',
                'name_en' => 'Women',
                'name_ar' => 'حريمي',
                'image' => 'subcategories/sneakers-women.jpg',
                'image_url' => 'https://loremflickr.com/900/600/womens,sneakers?lock=202',
                'status' => 1,
            ],
            [
                'category' => 'Sneakers',
                'name_en' => 'Kids',
                'name_ar' => 'أطفالي',
                'image' => 'subcategories/sneakers-kids.jpg',
                'image_url' => 'https://loremflickr.com/900/600/kids,sneakers?lock=203',
                'status' => 1,
            ],

            // Slippers
            [
                'category' => 'Slippers',
                'name_en' => 'Men',
                'name_ar' => 'رجالي',
                'image' => 'subcategories/slippers-men.jpg',
                'image_url' => 'https://loremflickr.com/900/600/mens,slippers?lock=204',
                'status' => 1,
            ],
            [
                'category' => 'Slippers',
                'name_en' => 'Women',
                'name_ar' => 'حريمي',
                'image' => 'subcategories/slippers-women.jpg',
                'image_url' => 'https://loremflickr.com/900/600/womens,slippers?lock=205',
                'status' => 1,
            ],
            [
                'category' => 'Slippers',
                'name_en' => 'Kids',
                'name_ar' => 'أطفالي',
                'image' => 'subcategories/slippers-kids.jpg',
                'image_url' => 'https://loremflickr.com/900/600/kids,slippers?lock=206',
                'status' => 1,
            ],
        ];

        Storage::disk('public')->makeDirectory('subcategories');

        foreach ($subcategories as $item) {

            $category = Category::where(
                'name_en',
                $item['category']
            )->first();

            if (!$category) {
                continue;
            }

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
                            "✓ Subcategory image downloaded: {$item['name_en']} - {$item['category']}"
                        );
                    } else {
                        $this->command?->warn(
                            "⚠ Failed subcategory image: {$item['name_en']}"
                        );
                    }
                } catch (\Throwable $e) {
                    $this->command?->warn(
                        "⚠ Subcategory image error: {$item['name_en']}"
                    );
                }
            }

            Subcategory::updateOrCreate(
                [
                    'name_en' => $item['name_en'],
                    'category_id' => $category->id,
                ],
                [
                    'name_ar' => $item['name_ar'],
                    'image' => $imagePath,
                    'status' => $item['status'],
                    'category_id' => $category->id,
                ]
            );
        }
    }
}