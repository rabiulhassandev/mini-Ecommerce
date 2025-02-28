<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__colors__';
    protected $fillable = ['name','color_code','status'];
}
