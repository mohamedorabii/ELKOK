<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'total_price',
        'color_name_en',
        'color_name_ar',
        'size_name_en',
        'size_name_ar',
        'variant_sku',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getVariantLabelAttribute(): ?string
    {
        $parts = array_filter([
            app()->getLocale() === 'ar' ? ($this->color_name_ar ?: $this->color_name_en) : ($this->color_name_en ?: $this->color_name_ar),
            app()->getLocale() === 'ar' ? ($this->size_name_ar ?: $this->size_name_en) : ($this->size_name_en ?: $this->size_name_ar),
        ]);

        return $parts ? implode(' / ', $parts) : null;
    }
}
