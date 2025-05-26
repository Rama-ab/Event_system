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

    public function create(array $data)
{
    $data['user_id'] = auth()->id(); 
    return Event::create($data);
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