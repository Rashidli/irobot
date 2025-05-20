<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'accessory_id',
        'locale',
        'img_alt',
        'img_title',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];
}
