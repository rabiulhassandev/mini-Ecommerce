<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributesSet extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__attributes_sets__';
    protected $fillable = ['title', 'status'];

    // Attribute Values
    public function attributeValues()
    {
        return $this->hasMany(AttributesValue::class, 'attribute_id');
    }
}
