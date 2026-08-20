<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getActiveProducts(?int $categoryId = null, int $perPage = 6)
    {
        $query = Product::where('status', 1)
            ->with(['variants'])
            ->whereHas('category', fn($q) => $q->where('status', 1));

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->paginate($perPage);
    }

    public function getProductDetails(int $id)
    {
        return Product::where('status', 1)
            ->with(['images', 'variants.color', 'variants.size'])
            ->whereHas('category', fn($q) => $q->where('status', 1))
            ->findOrFail($id);
    }

    public function getRelatedProducts(int $categoryId, int $excludeId, int $limit = 3)
    {
        return Product::where('status', 1)
            ->with(['variants'])
            ->where('category_id', $categoryId)
            ->where('id', '!=', $excludeId)
            ->whereHas('category', fn($q) => $q->where('status', 1))
            ->take($limit)
            ->get();
    }
}