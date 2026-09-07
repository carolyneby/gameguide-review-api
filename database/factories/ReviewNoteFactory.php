<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'guide_id' => Guide::factory(),
            'author_id' => User::factory(),
            'body' => fake()->randomElement([
                'Verify the boss health values against the latest patch notes.',
                'Add a screenshot for the hidden collectible on step 4.',
                'Double-check the item name — may have changed in the recent update.',
                'Good clarity overall; tighten up the intro paragraph.',
            ]),
        ];
    }
}
