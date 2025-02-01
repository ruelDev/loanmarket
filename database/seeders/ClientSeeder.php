<?php

namespace Database\Seeders;

use App\Models\ClientRecord;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientRecord::insert([
            [
                'name' => 'John Doe',
                'email' => '',
                'phone' => '09621234789',
                'broker_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
