<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        $this->call(AdminSeeder::class);

        // Categories & Subcategories
        $this->call(CategorySeeder::class);
        $this->call(SubcategorySeeder::class);

        // Brands
        $this->call(BrandSeeder::class);

        // Colors & Sizes
        $this->call(ColorSeeder::class);
        $this->call(SizeSeeder::class);

        // Products
        $this->call(ProductSeeder::class);

        // Product Variants
        $this->call(ProductVariantSeeder::class);
    }
}