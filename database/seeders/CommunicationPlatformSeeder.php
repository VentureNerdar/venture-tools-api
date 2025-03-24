<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunicationPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = ['Phone', 'Email', 'Facebook', 'Twitter / X', 'Other Social Links'];

        foreach ($platforms as $platform) {
            \App\Models\CommunicationPlatform::firstOrCreate([
                'name' => $platform,
            ]);
        }
    }
}
