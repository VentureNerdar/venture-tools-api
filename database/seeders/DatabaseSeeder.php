<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable mass assignment restrictions
        Model::unguard();

        // Call other seeders
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
            FieldTypeSeeder::class,
            StatusSeeder::class,
            PeopleGroupSeeder::class,
            FaithMilestoneSeeder::class,
            CommunicationPlatformSeeder::class,
            DenominationSeeder::class,
            MovementSeeder::class,
            TranslationSeeder::class,
            CommunityChecklistSeeder::class,

            CommunitySeeder::class,
            ChurchFactorySeeder::class,
            ContactFactorySeeder::class,
            UserFactorySeeder::class,
        ]);

        // Enable mass assignment restrictions
        Model::reguard();
    }
}
