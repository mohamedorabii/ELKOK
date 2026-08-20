<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name_en,
            'description'   => $this->desc_en,
            'price'         => $this->price,
            'image'         => $this->image ? asset('storage/' . $this->image) : null,
            'gallery_images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($image) => [
                'id'   => $image->id,
                'url'  => asset('storage/' . $image->image),
                'sort' => $image->sort_order,
            ])->values()),
            'variants'      => $this->whenLoaded('variants', fn () => $this->variants->map(fn ($variant) => [
                'id'          => $variant->id,
                'color_id'    => $variant->color_id,
                'color'       => $variant->color?->name,
                'size_id'     => $variant->size_id,
                'size'        => $variant->size?->name,
                'stock'       => $variant->stock,
                'price'       => $variant->effective_price,
                'sku'         => $variant->sku,
            ])->values()),
            'stock_quantity' => $this->stock_quantity,
            'has_variants'   => $this->has_variants,
            'category'       => $this->category?->name_en,
            'subcategory'    => $this->subcategory?->name_en,
            'brand'          => $this->brand?->name,
        ];
    }
}