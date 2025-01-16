<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'driver_id',
        'name', 
        'phone', 
        'licence_no', 
        'address', 
        'date',
        'status',
        'is_available',
    ];

    protected static function booted()
    {

        static::saving(function ($driver) {
            if ($driver->is_available) {
                $driver->status = 'Available';
            } else {
                $driver->status = 'Unavailable';
            }
        });
    }
}
