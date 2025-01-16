<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Mini Compost Bin',
            'category' => 'Compost Bins',
            'description' => 'Durable compost bin for home use.',
            'image_path' => 'images/mini_compostbin.jpg', 
            'price' => 2500.00,
            'stock_level' => 50,
        ]);
        
    }
}

