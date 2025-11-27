<?php

namespace Database\Seeders;

use App\Models\PeopleGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PeopleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/people-groups.json'));
        $peopleGroups = json_decode($json, true);

        $insertData = array_map(fn ($group) => [
            'name' => $group['name'],
            'rop3_code' => $group['rop3_code'],
        ], $peopleGroups);

        PeopleGroup::insert($insertData);
    }
}
