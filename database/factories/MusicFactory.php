<?php

namespace Database\Factories;

use App\Enum\GenreEnum;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artist_id' => Artist::inRandomOrder()->first()->id,
            'title' => fake()->sentence(1),
            'album_name' => fake()->sentence(1),
            'genre' => fake()->randomElement([GenreEnum::RNB->value, GenreEnum::CLASSIC->value, GenreEnum::COUNTRY->value, GenreEnum::JAZZ->value, GenreEnum::ROCK->value])
        ];
    }
}
