<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'super_admin',
                'Super Admin',
                'Super Admin role',
            ],
            [
                'developer',
                'Developer',
                'Developer role',
            ],
            [
                'movement_leader',
                'Movement Leader',
                'Movement Leader role',
            ],
            [
                'disciple_maker',
                'Disciple Maker',
                'Disciple Maker role',
            ],
            [
                'guest',
                'Guest',
                'Guest role',
            ]
        ];

        foreach ($roles as $role) {
            UserRole::firstOrCreate([
                'name' => $role[0],
                'label' => $role[1],
                'description' => $role[2],
            ]);
        }
    }
}
