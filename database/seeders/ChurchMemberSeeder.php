<?php

namespace Database\Seeders;

use App\Models\ChurchMember;
use Illuminate\Database\Seeder;

class ChurchMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChurchMember::factory()->count(10)->create();
    }
}
