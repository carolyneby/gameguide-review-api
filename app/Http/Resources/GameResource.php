<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'platform' => $this->platform,
            'release_year' => $this->release_year,
            'guide_count' => $this->whenCounted('guides'),
            'guides' => GuideResource::collection($this->whenLoaded('guides')),
        ];
    }
}
