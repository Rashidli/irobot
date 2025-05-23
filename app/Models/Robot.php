<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Robot extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['image', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);

    }

    public function items()
    {
        return $this->hasMany(RobotItem::class);
    }
}
