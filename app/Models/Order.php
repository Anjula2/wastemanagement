<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'delivery_option', 'address', 'total', 'status','is_completed'
    ];

    // Relationship with OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            if ($order->is_completed) {
                $order->status = 'completed';
            }
            elseif ($order->is_completed === false) {
                $order->status = 'cancelled';
            }
        });
    }
}

