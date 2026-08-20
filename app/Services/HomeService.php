<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class HomeService
{
    public function getActiveCategories()
    {
        return Category::where('status', 1)->get();
    }

    public function getCategory(int $id)
    {
        return Category::where('status', 1)->findOrFail($id);
    }

    public function getLatestProducts(int $limit = 6)
    {
        return Product::where('status', 1)
            ->with(['variants'])
            ->whereHas('category', fn($q) => $q->where('status', 1))
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getProductsByCategory(?int $categoryId = null, int $limit = 6)
    {
        $query = Product::where('status', 1)
            ->with(['variants'])
            ->whereHas('category', fn($q) => $q->where('status', 1))
            ->latest()
            ->take($limit);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }
}