<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_id',
        'quantity',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getUnitPriceAttribute(): float
    {
        return (float) ($this->variant?->effective_price ?? $this->product?->price ?? 0);
    }

    public function getAvailableStockAttribute(): int
    {
        if ($this->variant) {
            return (int) $this->variant->stock;
        }

        return (int) ($this->product?->stock_quantity ?? 0);
    }

    public function getVariantLabelAttribute(): ?string
    {
        return $this->variant?->variant_label;
    }
}
