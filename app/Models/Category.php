<?php

namespace App\Models;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Searchable;
    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'status',

    ];
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
        });
    }
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? ($this->name_ar ?: $this->name_en) : ($this->name_en ?: $this->name_ar);
    }

    public function toSearchableArray(): array
    {
        return [
            'id'      => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'status'  => $this->status,
        ];
    }
}
