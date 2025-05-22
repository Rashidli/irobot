<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotItemTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','description','robot_item_id','locale'];
}
