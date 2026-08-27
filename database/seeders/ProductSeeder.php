<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // ─── Sneakers > Men ─────────────────────────────────────

            [
                'category' => 'Sneakers',
                'subcategory' => 'Men',
                'brand' => 'Nike',
                'name_en' => 'Nike Air Max 90',
                'name_ar' => 'نايك اير ماكس 90',
                'image' => 'products/nike-air-max-90.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=1',
                'price' => 2400.00,
                'quantity' => 40,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Men',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Ultraboost 22',
                'name_ar' => 'أديداس الترا بوست 22',
                'image' => 'products/adidas-ultraboost-22.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=2',
                'price' => 2800.00,
                'quantity' => 35,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Men',
                'brand' => 'Puma',
                'name_en' => 'Puma RS-X',
                'name_ar' => 'بوما RS-X',
                'image' => 'products/puma-rs-x.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=3',
                'price' => 1900.00,
                'quantity' => 50,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Men',
                'brand' => 'Skechers',
                'name_en' => 'Skechers Go Walk 6',
                'name_ar' => 'سكيتشرز جو ووك 6',
                'image' => 'products/skechers-go-walk-6.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=4',
                'price' => 1500.00,
                'quantity' => 60,
                'status' => 1,
            ],

            // ─── Sneakers > Women ───────────────────────────────────

            [
                'category' => 'Sneakers',
                'subcategory' => 'Women',
                'brand' => 'Nike',
                'name_en' => 'Nike Air Force 1',
                'name_ar' => 'نايك اير فورس 1',
                'image' => 'products/nike-air-force-1-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=5',
                'price' => 2200.00,
                'quantity' => 55,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Women',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Stan Smith',
                'name_ar' => 'أديداس ستان سميث',
                'image' => 'products/adidas-stan-smith-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=6',
                'price' => 1800.00,
                'quantity' => 65,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Women',
                'brand' => 'New Balance',
                'name_en' => 'New Balance 574',
                'name_ar' => 'نيو بالانس 574',
                'image' => 'products/new-balance-574-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=7',
                'price' => 2100.00,
                'quantity' => 45,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Women',
                'brand' => 'Fila',
                'name_en' => 'Fila Disruptor 2',
                'name_ar' => 'فيلا ديسربتور 2',
                'image' => 'products/fila-disruptor-2-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=8',
                'price' => 1600.00,
                'quantity' => 50,
                'status' => 1,
            ],

            // ─── Sneakers > Kids ────────────────────────────────────

            [
                'category' => 'Sneakers',
                'subcategory' => 'Kids',
                'brand' => 'Nike',
                'name_en' => 'Nike Revolution 6 Kids',
                'name_ar' => 'نايك ريفوليوشن 6 أطفال',
                'image' => 'products/nike-revolution-6-kids.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=9',
                'price' => 1300.00,
                'quantity' => 70,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Kids',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Grand Court Kids',
                'name_ar' => 'أديداس جراند كورت أطفال',
                'image' => 'products/adidas-grand-court-kids.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=10',
                'price' => 1200.00,
                'quantity' => 80,
                'status' => 1,
            ],

            [
                'category' => 'Sneakers',
                'subcategory' => 'Kids',
                'brand' => 'Skechers',
                'name_en' => 'Skechers Light Up Kids',
                'name_ar' => 'سكيتشرز لايت أب أطفال',
                'image' => 'products/skechers-light-up-kids.jpg',
                'image_url' => 'https://loremflickr.com/800/800/sneakers?lock=11',
                'price' => 1400.00,
                'quantity' => 65,
                'status' => 1,
            ],

            // ─── Slippers > Men ─────────────────────────────────────

            [
                'category' => 'Slippers',
                'subcategory' => 'Men',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Adilette Slides',
                'name_ar' => 'شبشب أديداس أديليت',
                'image' => 'products/adidas-adilette-men.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=12',
                'price' => 650.00,
                'quantity' => 90,
                'status' => 1,
            ],

            [
                'category' => 'Slippers',
                'subcategory' => 'Men',
                'brand' => 'Nike',
                'name_en' => 'Nike Victori One Slides',
                'name_ar' => 'شبشب نايك فيكتوري وان',
                'image' => 'products/nike-victori-one-men.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=13',
                'price' => 700.00,
                'quantity' => 85,
                'status' => 1,
            ],

            [
                'category' => 'Slippers',
                'subcategory' => 'Men',
                'brand' => 'Puma',
                'name_en' => 'Puma Divecat Slides',
                'name_ar' => 'شبشب بوما دايفكات',
                'image' => 'products/puma-divecat-men.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=14',
                'price' => 550.00,
                'quantity' => 100,
                'status' => 1,
            ],

            // ─── Slippers > Women ───────────────────────────────────

            [
                'category' => 'Slippers',
                'subcategory' => 'Women',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Adilette Shower',
                'name_ar' => 'شبشب أديداس أديليت شاور',
                'image' => 'products/adidas-adilette-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=15',
                'price' => 650.00,
                'quantity' => 90,
                'status' => 1,
            ],

            [
                'category' => 'Slippers',
                'subcategory' => 'Women',
                'brand' => 'Nike',
                'name_en' => 'Nike Offcourt Slides',
                'name_ar' => 'شبشب نايك أوف كورت',
                'image' => 'products/nike-offcourt-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=16',
                'price' => 700.00,
                'quantity' => 80,
                'status' => 1,
            ],

            [
                'category' => 'Slippers',
                'subcategory' => 'Women',
                'brand' => 'Skechers',
                'name_en' => 'Skechers Comfy Slides',
                'name_ar' => 'شبشب سكيتشرز كومفي',
                'image' => 'products/skechers-comfy-women.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=17',
                'price' => 600.00,
                'quantity' => 95,
                'status' => 1,
            ],

            // ─── Slippers > Kids ────────────────────────────────────

            [
                'category' => 'Slippers',
                'subcategory' => 'Kids',
                'brand' => 'Adidas',
                'name_en' => 'Adidas Adilette Kids',
                'name_ar' => 'شبشب أديداس أديليت أطفال',
                'image' => 'products/adidas-adilette-kids.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=18',
                'price' => 450.00,
                'quantity' => 110,
                'status' => 1,
            ],

            [
                'category' => 'Slippers',
                'subcategory' => 'Kids',
                'brand' => 'Nike',
                'name_en' => 'Nike Kawa Slides Kids',
                'name_ar' => 'شبشب نايك كاوا أطفال',
                'image' => 'products/nike-kawa-kids.jpg',
                'image_url' => 'https://loremflickr.com/800/800/slippers?lock=19',
                'price' => 500.00,
                'quantity' => 100,
                'status' => 1,
            ],
        ];

        // Create products directory
        Storage::disk('public')->makeDirectory('products');

        foreach ($products as $item) {

            $category = Category::where('name_en', $item['category'])->first();

            if (! $category) {
                continue;
            }

            $subcategory = Subcategory::where('name_en', $item['subcategory'])
                ->where('category_id', $category->id)
                ->first();

            $brand = !empty($item['brand'])
                ? Brand::where('name_en', $item['brand'])->first()
                : null;

            /*
            |--------------------------------------------------------------------------
            | Generate Product Code
            |--------------------------------------------------------------------------
            */

            $prefix = strtoupper(
                substr(
                    preg_replace('/[^A-Za-z]/', '', $item['name_en']),
                    0,
                    3
                )
            );

            $code = $prefix . '-' . strtoupper(Str::random(4));

            /*
            |--------------------------------------------------------------------------
            | Download Product Image
            |--------------------------------------------------------------------------
            */

            $imagePath = $item['image'];

            if (! Storage::disk('public')->exists($imagePath)) {

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
                            "✓ Image downloaded: {$item['name_en']}"
                        );

                    } else {

                        $this->command?->warn(
                            "⚠ Image failed: {$item['name_en']}"
                        );
                    }

                } catch (\Throwable $e) {

                    $this->command?->warn(
                        "⚠ Image error: {$item['name_en']} - {$e->getMessage()}"
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create Product
            |--------------------------------------------------------------------------
            */

            Product::updateOrCreate(
                [
                    'name_en' => $item['name_en'],
                    'subcategory_id' => $subcategory?->id,
                    'category_id' => $category->id,
                ],
                [
                    'name_ar' => $item['name_ar'],
                    'desc_en' => $item['name_en'],
                    'desc_ar' => $item['name_ar'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'status' => $item['status'],
                    'code' => $code,
                    'brand_id' => $brand?->id,
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory?->id,
                    'image' => $imagePath,
                ]
            );
        }
    }
}