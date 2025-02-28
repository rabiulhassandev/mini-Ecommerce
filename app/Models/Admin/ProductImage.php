<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__product_images__';
    protected $fillable = ['url','product_id'];

    // Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
