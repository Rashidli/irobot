<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotAdvantageTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','description','robot_advantage_id','locale'];
}
