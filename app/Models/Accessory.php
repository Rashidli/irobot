<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    public array $translatedAttributes = [
        'title',
        'description',
        'short_description',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $fillable = [
        'image', 'is_active', 'accessory_category_id',
        'accessory_type_id','accessory_serie_id', 'price', 'is_stock', 'code',
        'discounted_price','room_area'
    ];

    protected $casts = [
        'is_stock' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function sliders(): MorphMany
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'accessory_product');
    }

}
