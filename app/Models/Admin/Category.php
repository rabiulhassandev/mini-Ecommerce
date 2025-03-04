<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__categories__';
    protected $fillable = ['name','slug', 'order', 'status', 'parent_id'];


    // Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Categories
    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // products
    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }
}
