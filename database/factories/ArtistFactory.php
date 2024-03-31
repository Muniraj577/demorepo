<?php

namespace Database\Factories;

use App\Enum\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'dob' => fake()->dateTime->format('Y-m-d'),
            'gender' => fake()->randomElement([GenderEnum::MALE->value, GenderEnum::FEMALE->value, GenderEnum::OTHERS->value]),
            'address' => fake()->address,
            'first_release_year' => fake()->year,
            'no_of_albums_released' => fake()->numberBetween(1, 50),
        ];
    }
}
