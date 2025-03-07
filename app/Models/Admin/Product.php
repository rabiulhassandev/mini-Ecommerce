<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use App\Models\Admin\Color;
use App\Models\Admin\AttributesValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__products__';
    protected $fillable = [
        'name',
        'slug',
        'price',
        'short_desc',
        'long_desc',
        'shipping_return',
        'additional_info',
        'thumbnail',
        'stock_status',
        'status',
        'attr_value_id',
        'color_id',
        'category_id'
    ];

    // category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Product Images
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // get colors
    public function getColorsAttribute()
    {
        // dd($this->color_id);
        $ids = json_decode($this->color_id);
        if ($ids) {
            return Color::whereIn('id', $ids)->get();
        }
        return [];
    }

    //
    public function getAttrValuesAttribute()
    {
        // dd($this->attr_value_id);
        $ids = json_decode($this->attr_value_id);
        if ($ids) {
            return AttributesValue::whereIn('id', $ids)->get();
        }
        return [];
    }


}
