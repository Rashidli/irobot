<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['image','is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'main_product');
    }
}
