<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaithMilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $milestones = [
            ['name' => 'Starting Churches', 'icon' => 'starting-church'],
            ['name' => 'Making Disciples', 'icon' => 'baptizing'],
            ['name' => 'Can Share Gospel', 'icon' => 'share-gospel'],
            ['name' => 'Baptized', 'icon' => 'baptized'],
            ['name' => 'In Church / Group', 'icon' => 'church'],
            ['name' => 'States Belief', 'icon' => 'testimony'],
            ['name' => 'Reading Bible', 'icon' => 'reading-bible'],
            [
                'name' => 'Has Bible',
                'icon' => 'bible',
            ],
        ];

        foreach ($milestones as $milestone) {
            \App\Models\FaithMilestone::firstOrCreate([
                'name' => $milestone['name'],
                'icon' => 'images/icons/faith-milestones/fm-' . $milestone['icon'] . '.png',
            ]);
        }
    }
}
