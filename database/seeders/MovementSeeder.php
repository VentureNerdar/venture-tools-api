<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movements = [
            [
                'name' => 'DMM',
                'description' => 'DMM'
            ],
            [
                'name' => 'LTC',
                'description' => 'LTC',
            ],
        ];

        foreach ($movements as $movement) {
            \App\Models\Movement::create([
                'name' => $movement['name'],
                'description' => $movement['description']
            ]);
        }
    }
}
