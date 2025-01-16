<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteOrder extends Model
{

    protected $fillable = [
        'user_id',
        'waste_type_id',
        'waste_type',
        'company_name',
        'address',
        'contact_number', 
        'quantity',
        'price_per_ton',
        'total_price',
        'status',
        'is_completed',
    ];
    
    public $timestamps = true;

    protected $attributes = [
        'status' => 'pending',
        'is_completed' => false,
    ];

    public function sellableWaste()
    {
        return $this->belongsTo(SellableWaste::class, 'waste_type_id', 'waste_type_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            if ($order->isDirty('is_completed')) {
                if ($order->is_completed) {
                    $order->status = 'completed';
                } elseif ($order->is_completed === false) {
                    $order->status = 'cancelled';
                }
            }

            // Ensure new orders retain the default "pending" status
            if (!$order->exists && $order->status === null) {
                $order->status = 'pending';
            }
        });
    }
}
