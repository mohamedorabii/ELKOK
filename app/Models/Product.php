<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Product extends Model
{

    use HasFactory, Searchable;
    protected $fillable = [
        'name_en',
        'name_ar',
        'price',
        'code',
        'desc_en',
        'desc_ar',
        'quantity',
        'subcategory_id',
        'brand_id',
        'category_id',
        'image',
        'status',
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->loadMissing('images');

            foreach ($product->images as $image) {
                if ($image->image && Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }
        });
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? ($this->name_ar ?: $this->name_en) : ($this->name_en ?: $this->name_ar);
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->desc_ar ?: $this->desc_en) : ($this->desc_en ?: $this->desc_ar);
    }

    public function getStockQuantityAttribute(): int
    {
        if ($this->relationLoaded('variants') && $this->variants->isNotEmpty()) {
            return (int) $this->variants->sum('stock');
        }

        if ($this->relationLoaded('variants') && $this->variants->isEmpty()) {
            return (int) $this->quantity;
        }

        if ($this->variants()->exists()) {
            return (int) $this->variants()->sum('stock');
        }

        return (int) $this->quantity;
    }

    public function getHasVariantsAttribute(): bool
    {
        if ($this->relationLoaded('variants')) {
            return $this->variants->isNotEmpty();
        }

        return $this->variants()->exists();
    }

    public function toSearchableArray(): array
    {
        return [
            'id'      => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'desc_en' => $this->desc_en,
            'desc_ar' => $this->desc_ar,
            'status'  => $this->status,
        ];
    }
}
