<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'game_id' => $this->game_id,
            'game_title' => $this->whenLoaded('game', fn () => $this->game->title),
            'review_notes' => ReviewNoteResource::collection($this->whenLoaded('reviewNotes')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
