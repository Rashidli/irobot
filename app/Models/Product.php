<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use HasFactory, Translatable, SoftDeletes;

    public array $translatedAttributes = [
        'title',
        'description',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'color',
    ];

    protected $fillable = [
        'image', 'is_active', 'category_id',
        'type_id', 'price', 'is_stock', 'code', 'room_area',
        'discounted_price',
        'mess_coming',
        'floor_home',
        'level_clutter',
        'product_serie_id',
        'is_new',
        'is_bestseller',
        'is_paket',
    ];

    protected $casts = [
        'is_stock' => 'boolean',
        'is_new' => 'boolean',
        'is_paket' => 'boolean',
        'is_bestseller' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function sliders(): MorphMany
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function product_faqs(): HasMany
    {
        return $this->hasMany(ProductFaq::class);
    }

    public function product_details(): HasMany
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function product_features(): HasMany
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function product_colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, 'accessory_product');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function type() : BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function product_serie() : BelongsTo
    {
        return $this->belongsTo(ProductSerie::class);
    }


}
