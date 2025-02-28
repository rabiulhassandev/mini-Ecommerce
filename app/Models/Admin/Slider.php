<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__sliders__';
    protected $fillable = ['title','desc','others', 'image', 'order', 'status'];
}
