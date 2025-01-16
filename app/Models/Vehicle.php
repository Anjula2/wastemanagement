<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_no', 
        'type', 
        'date',
        'status',
        'is_available',
    ];

    protected static function booted()
    {
        static::saving(function ($vehicle) {
            if ($vehicle->is_available) {
                $vehicle->status = 'Available';
            } else if (!$vehicle->is_available) {
                $vehicle->status = 'Under Maintenance';
            }
        });
    }
}
