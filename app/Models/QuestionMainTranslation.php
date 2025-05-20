<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionMainTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title','description','question_main_id','locale'];

}
