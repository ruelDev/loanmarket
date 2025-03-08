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
                'email' => 'melissa.howard@raywhite.com',
                'tagline' => 'Your Investment. Our Priority.',
                'call_to' => 'Accountants',
                'featured' => 'assets/images/raywhite/onegroup/bg.webp',
                'logo' => 'assets/images/raywhite/logo.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'RayWhite - Mooloolaba',
                'url' => 'raywhite-mooloolaba',
                'email' => 'mooloolaba.qld@raywhite.com',
                'tagline' => 'One Team. Two Locations.',
                'call_to' => 'Financial Reviewers',
                'featured' => 'assets/images/raywhite/mooloolaba/bg.webp',
                'logo' => 'assets/images/raywhite/logo.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
