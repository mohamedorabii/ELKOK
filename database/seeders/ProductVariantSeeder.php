<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $colors = Color::where('status', 1)->get()->keyBy('name_en');
        $sizes  = Size::where('status', 1)->get()->keyBy('name_en');

        $products = Product::all();

        foreach ($products as $product) {

            $subcategory = strtolower($product->subcategory?->name_en ?? '');

            /*
            |--------------------------------------------------------------------------
            | Determine available sizes
            |--------------------------------------------------------------------------
            */

            if ($subcategory === 'kids') {
                $availableSizes = [
                    '28',
                    '29',
                    '30',
                    '31',
                    '32',
                    '33',
                    '34',
                    '35',
                ];
            } else {
                $availableSizes = [
                    '39',
                    '40',
                    '41',
                    '42',
                    '43',
                    '44',
                    '45',
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Determine available colors
            |--------------------------------------------------------------------------
            */

            $availableColors = [
                'Black',
                'White',
                'Grey',
            ];

            /*
            |--------------------------------------------------------------------------
            | Create variants
            |--------------------------------------------------------------------------
            */

            foreach ($availableColors as $colorName) {

                $color = $colors->get($colorName);

                if (!$color) {
                    continue;
                }

                foreach ($availableSizes as $sizeName) {

                    $size = $sizes->get($sizeName);

                    if (!$size) {
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | SKU
                    |--------------------------------------------------------------------------
                    */

                    $sku = sprintf(
                        'ELK-%03d-C%02d-S%s',
                        $product->id,
                        $color->id,
                        $size->name_en
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Stock
                    |--------------------------------------------------------------------------
                    */

                    $stock = fake()->numberBetween(3, 25);

                    // Some variants intentionally out of stock
                    if (fake()->boolean(10)) {
                        $stock = 0;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Variant Price
                    |--------------------------------------------------------------------------
                    |
                    | Use product price as the default variant price.
                    |
                    */

                    $price = $product->price;

                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'color_id'   => $color->id,
                            'size_id'    => $size->id,
                        ],
                        [
                            'stock' => $stock,
                            'price' => $price,
                            'sku'   => $sku,
                        ]
                    );
                }
            }
        }
    }
}