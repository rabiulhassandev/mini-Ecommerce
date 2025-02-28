<?php

namespace App\Models\Admin;

use App\Traits\WithCache;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserStatus extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__user_status__';
    protected $fillable = ['name',];

    public function users()
    {
        return $this->hasMany(User::class, 'user_status_id');
    }
}
