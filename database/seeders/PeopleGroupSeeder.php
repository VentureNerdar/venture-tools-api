<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'Chamar (Hindu traditions)',
            'Chepang',
            'Chhetri',
            'Darjee',
            'Dhanuk Dhankar',
            'Jat (Hindu Traditions)',
            'Kami',
            'Koiri (Hindu traditions)',
            'Magar',
            'Majhi',
            'Newar',
            'Rajput Saithwar',
            'Sarki',
            'Sherpa',
            'Sonar (Hindu traditions)',
            'Sunuwar',
            'Teli (Hindu traditions)',
            'Thakali Tin Gaule',
            'Thakuri',
            'Thamang',
            'Thapa',
            'Tharu',
            'Tsum',
            'Yakha',
            'Yakthumba',
            'Yadav (Hindu traditions)',
            'Yadav Gualbans (Hindu traditions)',
            'Yadav Rawat',
            'Yamphu',
            'Yehlmo',
            'Other'
        ];

        foreach ($groups as $group) {
            \App\Models\PeopleGroup::create([
                'name' => $group,
            ]);
        }
    }
}
