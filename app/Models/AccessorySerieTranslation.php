<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessorySerieTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','accessory_serie_id','locale'];
}
