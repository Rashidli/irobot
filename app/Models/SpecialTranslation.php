<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','special_id','locale','description','image1'];

}
