<?php

namespace Database\Seeders;

use App\Models\Lenders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lenders::insert([
            [
                'name' => 'CBA',
                'logo' => 'assets/images/lenders/Commonwealth.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Macquarie',
                'logo' => 'assets/images/lenders/macquarie.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'St. George',
                'logo' => 'assets/images/lenders/stGeorge.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
