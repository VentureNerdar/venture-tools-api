<?php

namespace Database\Factories;

use App\Enums\AgeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Gender as GenderEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nickname' => fake()->name(),
            'gender' => fake()->randomElement([GenderEnum::MALE->value, GenderEnum::FEMALE->value]),
            'age' => fake()->randomElement([
                AgeGroup::UNDER_EIGHTEEN_YEARS_OLD,
                AgeGroup::EIGHTEEN_TWENTY_FIVE_YEARS_OLD,
                AgeGroup::TWENTY_SIX_FORTY_YEARS_OLD,
                AgeGroup::OVER_FORTY_YEARS_OLD,
            ]),
            'baptism_date' => fake()->dateTime(),
            'current_prayers' => fake()->paragraph(),
            'contact_status_id' => random_int(1, 5),
            'faith_status_id' => random_int(8, 10),
        ];
    }
}
