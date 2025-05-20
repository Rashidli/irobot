<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'product_id',
        'locale',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'color',
    ];

}
