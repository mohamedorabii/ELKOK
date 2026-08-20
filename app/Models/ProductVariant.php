<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'stock',
        'price',
        'sku',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->price ?? $this->product?->price ?? 0);
    }

    public function getVariantLabelAttribute(): string
    {
        $parts = array_filter([
            $this->color?->name,
            $this->size?->name,
        ]);

        return implode(' / ', $parts);
    }
}