<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommunityChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checklists = [
            'Person of Peace',
            'Regular Prayer Walks',
            'Established Local Ownership',
            'Created small groups',
            'Committee meets regularly',
            'Conducted Community Training Program',
            'Recruitment of Volunteers',
            'Evaluation of Results',
        ];

        foreach ($checklists as $item) {
            \App\Models\CommunityChecklist::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
