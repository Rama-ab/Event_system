<?php

namespace App\Services;

use App\Models\EventType;

class EventTypeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function list()
    {
        return EventType::withCount('events')->get();
    }

    public function create(array $data)
    {
        return EventType::create($data);
    }

    public function update(EventType $eventType, array $data)
    {
        $eventType->update($data);
        return $eventType;
    }

    public function delete(EventType $eventType)
    {
        return $eventType->delete();
    }
}
