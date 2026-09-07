<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Guide;
use App\Models\ReviewNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // A known user for easy local testing of Sanctum-protected routes.
        $reviewer = User::factory()->create([
            'name' => 'Carolyn Eby',
            'email' => 'carolyn@example.com',
        ]);

        Game::factory(3)
            ->has(Guide::factory()
                ->count(4)
                ->has(ReviewNote::factory()->count(2)->state([
                    'author_id' => $reviewer->id,
                ])))
            ->create();
    }
}
