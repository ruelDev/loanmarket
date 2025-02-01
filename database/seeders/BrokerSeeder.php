<?php

namespace Database\Seeders;

use App\Models\Brokers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brokers::insert([
            [
                'name' => 'Christian B. Pascual',
                'email' => 'cpascual@gmail.com',
                'phone' => '09621234789',
                'rso' => json_encode(['CBA', 'St. George']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David A. Cruz',
                'email' => 'dcruz@gmail.com',
                'phone' => '09621784563',
                'rso' => json_encode(['Macquarie', 'St. George']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Estela A. Santos',
                'email' => 'esantos@gmail.com',
                'phone' => '09617891596',
                'rso' => json_encode(['Macquarie', 'CBA']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
