<?php

namespace Database\Factories;

use App\Models\Church;
use App\Models\PeopleGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChurchMember>
 */
class ChurchMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'church_id' => Church::inRandomOrder()->value('id') ?? Church::factory(),
            'people_group_id' => PeopleGroup::inRandomOrder()->value('id'),
            'amount' => $this->faker->numberBetween(1, 100),
        ];
    }
}
