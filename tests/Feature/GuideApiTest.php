<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_guides(): void
    {
        Guide::factory()->count(3)->create();

        $response = $this->getJson('/api/guides');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_filter_guides_by_status(): void
    {
        Guide::factory()->create(['status' => 'published']);
        Guide::factory()->create(['status' => 'draft']);

        $response = $this->getJson('/api/guides?status=published');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.status', 'published');
    }

    public function test_creating_a_guide_requires_a_valid_game(): void
    {
        $response = $this->postJson('/api/guides', [
            'game_id' => 999, // doesn't exist
            'title' => 'Chapter 5 Walkthrough',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('game_id');
    }

    public function test_creating_a_guide_requires_a_title(): void
    {
        $game = Game::factory()->create();

        $response = $this->postJson('/api/guides', [
            'game_id' => $game->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function test_guest_cannot_create_a_review_note(): void
    {
        $guide = Guide::factory()->create();

        $response = $this->postJson('/api/review-notes', [
            'guide_id' => $guide->id,
            'body' => 'Please verify the boss strategy against the latest patch.',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_a_review_note(): void
    {
        $user = User::factory()->create();
        $guide = Guide::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/review-notes', [
            'guide_id' => $guide->id,
            'body' => 'Please verify the boss strategy against the latest patch.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('review_notes', [
            'guide_id' => $guide->id,
            'author_id' => $user->id,
        ]);
    }
}
