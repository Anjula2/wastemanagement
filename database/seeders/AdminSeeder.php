<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'John Bailey',
            'email' => 'john@kmc.gov',
            'password' => Hash::make('password123'),
        ]);
    }
}

