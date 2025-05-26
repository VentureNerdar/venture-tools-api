<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'is_active' => true,
            'location_longitude' => $this->faker->longitude,
            'location_latitude' => $this->faker->latitude,
            'conducted_survey_of_community_needs' => $this->faker->boolean,
            'created_by' => 4,
            'community_needs_1' => $this->faker->sentence,
            'community_needs_2' => $this->faker->sentence,
            'community_needs_3' => $this->faker->sentence,
            'community_needs_4' => $this->faker->sentence,
            'community_needs_5' => $this->faker->sentence,
        ];
    }
}
