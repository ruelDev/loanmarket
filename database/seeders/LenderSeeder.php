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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Macquarie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'St. George',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
