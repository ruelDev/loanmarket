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
                'name' => 'RayWhite - One Group',
                'url' => 'raywhite-one-group',
                'email' => 'raywhite@gmail.com',
                'tagline' => 'Your Investment. Our Priority.',
                'call_to' => 'Accountants',
                'featured' => 'assets/images/raywhite/bg.webp',
                'logo' => 'assets/images/raywhite/logo.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Housemark',
                'url' => 'housemark',
                'email' => 'housemark@gmail.com',
                'tagline' => 'Rental Properties Properly Managed',
                'call_to' => 'Financial Reviewers',
                'featured' => 'assets/images/housemark/bg.webp',
                'logo' => 'assets/images/housemark/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
