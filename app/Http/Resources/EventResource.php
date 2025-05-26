<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time ? $this->start_time->format('Y-m-d H:i:s') : null,
            'end_time' => $this->end_time ? $this->end_time->format('Y-m-d H:i:s') : null,
            'event_type' => $this->eventType->name ?? null,
            'location' => $this->location->name ?? null,
            'user' => $this->user->name ?? null,
            'main_image' => $this->mainImage->path ?? null,
        ];
    }
}