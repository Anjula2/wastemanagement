<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellableWaste extends Model
{
    protected $fillable = [
        'waste_type_id',
        'waste_type',
        'stock_level',
        'price',
        'description',
    ];

    protected $table = 'sellable_wastes'; 

    public function setTotalPriceAttribute($value)
    {
        if (isset($this->attributes['price']) && isset($this->attributes['quantity'])) {
            $this->attributes['total_price'] = $this->attributes['price'] * $this->attributes['quantity'];
        }
    }
}
