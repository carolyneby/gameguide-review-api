<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'title' => fake()->randomElement([
                'Chapter 1 Walkthrough',
                'All Collectibles Guide',
                'Boss Strategy: Final Encounter',
                'Side Quest Checklist',
                'Achievement/Trophy Guide',
            ]),
            'status' => fake()->randomElement(['draft', 'in_review', 'published']),
        ];
    }
}
