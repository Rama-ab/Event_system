<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\Image\UploadImageRequest;

class EventController extends Controller
{
    public function __construct(protected EventService $eventService)
    {
     $this->middleware('permission:view events')->only(['index', 'show']);
        $this->middleware('permission:create events')->only('store');
        $this->middleware('permission:update events')->only('update');
        $this->middleware('permission:delete events')->only('destroy');    }
    
    public function index()
    {
        $events = $this->eventService->list();
        return response()->json($events);
    }

    public function filter(Request $request)
    {
        $events = $this->eventService->getFilteredEvents(
            $request->type_id ?? 1,
            $request->location_id ?? 1
        );

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->create($request->validated());
        return new EventResource($event->load('mainImage'));
    }

    public function show(Event $event)
    {
        return new EventResource($event->load(['eventType', 'location', 'user', 'images']));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $updatedEvent = $this->eventService->update($event, $request->validated());
        return new EventResource($updatedEvent->load('mainImage'));
    }

    public function destroy(Event $event)
    {
        $this->eventService->delete($event);
        return response()->json(['message' => 'Event deleted.']);
    }

    public function addImage(UploadImageRequest $request, Event $event, ImageUploadService $imageService)
    {
        $path = $imageService->upload($event, $request->file('image'));

        return response()->json([
            'message' => 'Image uploaded successfully.',
            'path' => $path,
        ]);
    }
}