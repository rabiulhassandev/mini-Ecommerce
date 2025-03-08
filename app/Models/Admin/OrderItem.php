<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__order_items__';
    protected $fillable = [
        'quantity',
        'rate',
        'total',
        'color_id',
        'size_id',
        'product_id',
        'order_id'
    ];

    // Color
    public function color(){
        return $this->belongsTo(Color::class, 'color_id');
    }

    // Size
    public function size(){
        return $this->belongsTo(AttributesValue::class, 'size_id');
    }
    
    // Order
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Product
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
