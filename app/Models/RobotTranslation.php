<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','description','robot_id','locale'];
}
