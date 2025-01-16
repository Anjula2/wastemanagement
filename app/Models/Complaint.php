<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'details',
        'file_path',
        'status',
        'date',
        'address',
        'is_completed',
    ];

    protected static function booted()
    {
        static::saving(function ($complaint) {
            if ($complaint->is_completed) {
                $complaint->status = 'Resolved';
            } 
        });
    }
}
