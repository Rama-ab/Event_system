<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventService
{
    public function list()
    {
        return Event::with(['eventType', 'location', 'user', 'images'])->latest()->get();
    }

    public function create(array $data): Reservation
    {
        return Reservation::create([
            'user_id' => auth()->id(),
            'event_id' => $data['event_id'],
            'seats' => $data['seats'],
        ]);
    }

    public function update(Event $event, array $data)
    {
        $event->update($data);
        return $event->fresh();
    }

    public function delete(Event $event)
    {
        return $event->delete();
    }

    public function getFilteredEvents(int $typeId, int $locationId)
    {
        return Event::with('mainImage')
            ->upcoming()
            ->ofType($typeId)
            ->atLocation($locationId)
            ->get();
    }
}