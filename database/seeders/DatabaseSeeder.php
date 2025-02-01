<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LenderSeeder::class);
        $this->call(ROSSeeder::class);
        $this->call(BrokerSeeder::class);
        $this->call(UserSeeder::class);
    }
}
