<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewNoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'guide_id' => $this->guide_id,
            'author_name' => $this->whenLoaded('author', fn () => $this->author->name),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
