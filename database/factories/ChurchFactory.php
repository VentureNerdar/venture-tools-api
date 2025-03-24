<?php

namespace Database\Factories;

use App\Models\Church;
use App\Models\Community;
use App\Models\Denomination;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Church>
 */
class ChurchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => $this->faker->boolean(90),
            'assigned_to' => User::inRandomOrder()->value('id') ?? User::factory(),
            'name' => $this->generateChurchName(),
            'description' => $this->faker->paragraph(),
            'founded_at' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'denomination_id' => Denomination::inRandomOrder()->value('id') ?? Denomination::factory(),
            'is_visited' => $this->faker->boolean(50),
            'church_members_count' => $this->faker->numberBetween(10, 1000),
            'confession_of_faith_count' => $this->faker->numberBetween(10, 1000),
            'baptism_count' => $this->faker->numberBetween(10, 1000),
            'parent_church_id' => Church::inRandomOrder()->value('id') ?? null,
            'current_prayers' => $this->faker->paragraph(),
            'community_id' => Community::inRandomOrder()->value('id') ?? Community::factory(),
        ];
    }

    private function generateChurchName()
    {
        $prefixes = ['St.', 'Holy', 'Grace', 'First', 'New', 'Blessed', 'Redeemer', 'Faith', 'Hope', 'Sacred', 'Trinity'];
        $suffixes = ['Church', 'Chapel', 'Fellowship', 'Cathedral', 'Tabernacle', 'Assembly', 'Mission', 'Ministries', 'Congregation'];
        // $locations = [$this->faker->city, $this->faker->state, 'Community', 'United'];
        $locations = [fake()->city(), fake()->state(), 'Community', 'United'];

        return fake()->randomElement($prefixes) . ' ' . fake()->randomElement($locations) . ' ' . fake()->randomElement($suffixes);
    }
}
