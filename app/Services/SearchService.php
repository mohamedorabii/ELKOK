<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class SearchService
{
    public function search(string $query, int $perPage = 9): array
    {
        $products = Product::search($query)
            ->query(fn ($builder) => $builder->with(['variants']))
            ->where('status', 1)
            ->paginate($perPage);

        $categories = Category::search($query)
            ->where('status', 1)
            ->get();

        $brands = Brand::search($query)
            ->where('status', 1)
            ->get();

        $subcategories = Subcategory::search($query)
            ->where('status', 1)
            ->get();

        return compact('products', 'categories', 'brands', 'subcategories');
    }
}