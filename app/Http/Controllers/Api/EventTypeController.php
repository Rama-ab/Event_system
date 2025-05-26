<?php

namespace App\Http\Controllers\Api;

use App\Models\EventType;
use Illuminate\Http\Request;
use App\Services\EventTypeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventType\StoreEventTypeRequest;
use App\Http\Requests\EventType\UpdateEventTypeRequest;

class EventTypeController extends Controller
{
    public function __construct(protected EventTypeService $eventTypeService) {

    $this->middleware('permission:view event types')->only('index');
    $this->middleware('permission:create event types')->only('store');
    $this->middleware('permission:update event types')->only('update');
    $this->middleware('permission:delete event types')->only('destroy');
    }

    public function index()
    {
        return response()->json($this->eventTypeService->list());
    }

    public function store(StoreEventTypeRequest $request)
    {
        $type = $this->eventTypeService->create($request->validated());
        return response()->json(['message' => 'Event type created.', 'type' => $type], 201);
    }

    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        $type = $this->eventTypeService->update($eventType, $request->validated());
        return response()->json(['message' => 'Event type updated.', 'type' => $type]);
    }

    public function destroy(EventType $eventType)
    {
        $this->eventTypeService->delete($eventType);
        return response()->json(['message' => 'Event type deleted.']);
    }
}
