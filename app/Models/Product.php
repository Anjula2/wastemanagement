<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'category',
        'description',
        'image_path',
        'price',
        'stock_level',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}

