<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributesValue extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__attributes_values__';
    protected $fillable = ['value', 'attribute_id', 'status'];

    // Attribute
    public function attribute()
    {
        return $this->belongsTo(AttributesSet::class, 'attribute_id');
    }
}
