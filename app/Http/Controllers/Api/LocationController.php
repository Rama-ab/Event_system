<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use App\Http\Requests\Image\UploadImageRequest;
use App\Http\Requests\Location\StoreLocationeRequest;
use App\Http\Requests\Location\UpdateLocationeRequest;

class LocationController extends Controller
{
    public function __construct(protected LocationService $locationService) {

        $this->middleware('permission:view locations')->only(['index', 'show']);
        $this->middleware('permission:create locations')->only('store');
        $this->middleware('permission:update locations')->only('update');
        $this->middleware('permission:delete locations')->only('destroy');
    }

    public function index()
    {
        return response()->json($this->locationService->list());
    }

    public function store(StoreLocationeRequest $request)
    {
        $location = $this->locationService->create($request->validated());
        return response()->json(['message' => 'Location created.', 'location' => $location], 201);
    }

    public function show(Location $location)
    {
        return response()->json($location->load(['evenys', 'LatestImage']));
    }

    public function update(UpdateLocationeRequest $request, Location $location)
    {
        $location = $this->locationService->update($location, $request->validated());
        return response()->json(['message' => 'Location updated.', 'location' => $location]);
    }

    public function destroy(Location $location)
    {
        $this->locationService->delete($location);
        return response()->json(['message' => 'Location deleted.']);
    }


    public function addImage(UploadImageRequest $request, Location $location, ImageUploadService $imageService)
    {
        $path = $imageService->upload($event, $request->file('image'));
    
        return response()->json([
            'message' => 'Image uploaded successfully.',
            'path' => $path,
        ]);
    }
}



 