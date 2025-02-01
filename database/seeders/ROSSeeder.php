<?php

namespace Database\Seeders;

use App\Models\ROS;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ROSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ROS::insert([
            [
                'name' => 'RayWhite Rochedale',
                'email' => 'raywhite_rochedale@gmail.com',
                'tagline' => 'We don\'t sell houses, We sell  homes.',
                'featured' => 'assets/images/raywhite/rochedale/bg.png',
                'logo' => 'assets/images/raywhite/rochedale/logo.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kawana',
                'email' => 'kawana@gmail.com',
                'tagline' => 'One Team. Two Locations.',
                'featured' => 'assets/images/raywhite/kawana/bg.jpg',
                'logo' => 'assets/images/raywhite/kawana/logo.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
