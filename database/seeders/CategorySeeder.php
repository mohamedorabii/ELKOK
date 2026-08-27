<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Sneakers',
                'name_ar' => 'كوتشيات',
                'image' => 'categories/sneakers.jpg',
                'image_url' => 'https://loremflickr.com/900/600/sneakers?lock=101',
                'status' => 1,
            ],
            [
                'name_en' => 'Slippers',
                'name_ar' => 'شباشب',
                'image' => 'categories/slippers.jpg',
                'image_url' => 'https://loremflickr.com/900/600/slippers?lock=102',
                'status' => 1,
            ],
        ];

        Storage::disk('public')->makeDirectory('categories');

        foreach ($categories as $item) {

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
                            "✓ Category image downloaded: {$item['name_en']}"
                        );
                    } else {
                        $this->command?->warn(
                            "⚠ Failed category image: {$item['name_en']}"
                        );
                    }
                } catch (\Throwable $e) {
                    $this->command?->warn(
                        "⚠ Category image error: {$item['name_en']}"
                    );
                }
            }

            Category::updateOrCreate(
                [
                    'name_en' => $item['name_en'],
                ],
                [
                    'name_ar' => $item['name_ar'],
                    'image' => $imagePath,
                    'status' => $item['status'],
                ]
            );
        }
    }
}