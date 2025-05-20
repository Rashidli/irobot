<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title', 'product_color_id', 'locale'];

}
