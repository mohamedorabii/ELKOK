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
    protected static function booted()
    {
        static::creating(function ($variant) {
            if (empty($variant->sku)) {
                $variant->sku = static::generateUniqueSku($variant);
            }
        });

        static::updating(function ($variant) {
            if (empty($variant->sku) || $variant->isDirty(['color_id', 'size_id'])) {
                $variant->sku = static::generateUniqueSku($variant);
            }
        });
    }

    protected static function generateUniqueSku($variant): string
    {
        $product     = $variant->product ?? Product::find($variant->product_id);
        $productCode = $product?->code ?? 'PRD';

        $colorPart = $variant->color_id ? 'C' . str_pad($variant->color_id, 2, '0', STR_PAD_LEFT) : 'C00';
        $sizePart  = 'S00';

        if ($variant->size_id) {
            $sizeName = Size::find($variant->size_id)?->name_en;
            $sizePart = 'S' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $sizeName ?? $variant->size_id));
        }

        $baseSku = "{$productCode}-{$colorPart}-{$sizePart}";
        $sku     = $baseSku;
        $counter = 1;

        while (static::where('sku', $sku)->where('id', '!=', $variant->id ?? 0)->exists()) {
            $counter++;
            $sku = "{$baseSku}-{$counter}";
        }

        return $sku;
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
