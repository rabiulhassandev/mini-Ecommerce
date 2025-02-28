<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use App\Models\Admin\Color;
use App\Models\Admin\AttributesValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__products__';
    protected $fillable = ['name', 'slug', 'unit', 'min_order_qty', 'unit_price', 'sku', 'shipping_days', 'short_desc', 'long_desc', 'additional_info', 'thumbnail', 'meta_title', 'meta_desc', 'meta_keywords', 'meta_image', 'featured_status', 'todays_deal_status', 'stock_status', 'status', 'category_id', 'attr_value_id'];

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
        // dd($this->attr_value_id);
        $ids = json_decode($this->attr_value_id);
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
