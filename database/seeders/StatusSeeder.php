<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'contact' => [
                'Active',
                'Paused',
                'Archived',
                'New Contact',
                'Not Ready'
            ],
            'group' => [
                'Active',
                'Inactive'
            ],
            'position' => [
                'Person of Peace',
                'Believer',
                'Disciple',
                'Leader',
                'Disciple Maker',
                'Church Planter'
            ],
        ];

        foreach ($statuses as $type => $names) {
            foreach ($names as $name) {
                \App\Models\Status::firstOrCreate([
                    'name' => $name,
                    'type' => $type,
                ]);
            }
        }
    }
}
