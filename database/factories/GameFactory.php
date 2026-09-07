<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Starlight Dungeon',
                'Rift Chasers',
                'The Last Cartographer',
                'Moonlit Archive',
                'Ember & Ash',
            ]),
            'platform' => fake()->randomElement(['Nintendo Switch', 'PC', 'PlayStation 5', 'Xbox Series X']),
            'release_year' => fake()->numberBetween(2018, 2026),
        ];
    }
}
