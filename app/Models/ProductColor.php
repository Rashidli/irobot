<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{

    use HasFactory, Translatable, SoftDeletes;
    public $translatedAttributes = ['title'];
    protected $fillable = ['is_active','image','is_default'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}
