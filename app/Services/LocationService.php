<?php

namespace App\Services;

use App\Models\Location;

class LocationService
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
        return Location::withCount('events')->get();
    }

    public function create(array $data)
    {
        return Location::create($data);
    }

    public function update(Location $location, array $data)
    {
        $location->update($data);
        return $location;
    }

    public function delete(Location $location)
    {
        return $location->delete();
    }
}
