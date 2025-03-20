<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Traits\WithCache;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__orders__';
    protected $fillable = [
        'name',
        'addr',
        'phone',
        'is_inside_area',
        'payment_method',
        'sub_total',
        'shipping_fee',
        'total',
        'is_paid',
        'order_id',
        'status',
        'user_id'
    ];

    // User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Generate Order ID
    public static function generateOrderId()
    {
        do {
            $order_id = 'ORD' . "-" . Str::upper(Str::random(8)); // Generates a 8-character unique ID
        } while (self::where('order_id', $order_id)->exists());

        return $order_id;
    }

    // Get Order Status
    public function getStatus()
    {
        $status = Str::lower($this->status); // Correctly reference the instance's status

        $badge = 'bg-warning text-white';
        $text = 'Pending';

        if ($status == 'processing') {
            $badge = 'bg-info text-white';
            $text = 'Processing';
        } elseif ($status == 'completed') {
            $badge = 'bg-success text-white';
            $text = 'Completed';
        } elseif ($status == 'cancelled') {
            $badge = 'bg-danger text-white';
            $text = 'Cancelled';
        }

        return "<span class='badge {$badge}'>{$text}</span>";
    }


    // Get Payment Status
    public function getPaymentStatus()
    {
        $badge = 'bg-warning text-white';
        $text = 'Unpaid';

        if ($this->is_paid) {
            $badge = 'bg-success text-white';
            $text = 'Paid';
        }

        return "<span class='badge {$badge}'>{$text}</span>";
    }
}
