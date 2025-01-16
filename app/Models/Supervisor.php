<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'supervisor_id',
        'zone_id',
        'name',
        'phone',
        'nic_no',
        'address',
        'date',
        'status',
        'is_available',
    ];

    protected static function booted()
    {
        static::saving(function ($supervisor) {
            if ($supervisor->is_available) {
                $supervisor->status = 'Available';
            } else if (!$supervisor->is_available) {
                $supervisor->status = 'Unavailable';
            }
        });
    }
    
}
