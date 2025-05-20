<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryTypeTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','description','accessory_type_id','locale'];

}
