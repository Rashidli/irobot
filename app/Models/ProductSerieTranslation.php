<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSerieTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','product_serie_id','locale'];
}
