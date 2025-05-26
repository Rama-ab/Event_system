<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $service)
    {

        $this->middleware('permission:view reservations')->only(['index', 'show']);
        $this->middleware('permission:create reservations')->only('store');
        $this->middleware('permission:delete reservations')->only('destroy');
    }

    public function index()
    {
        $reservations = Reservation::with(['event', 'event.location'])
            ->MineOrAll()
            ->withCount('event')
            ->get();

        return response()->json($reservations);
    }

    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->service->create($request->validated());

        return response()->json([
            'reservation' => $reservation,
            'created' => $reservation->wasRecentlyCreated,
        ], 201);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation = $this->service->update($reservation, $request->validated());

        return response()->json([
            'reservation' => $reservation,
            'dirty' => $reservation->isDirty(), //after update will be false
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $this->service->delete($reservation);

        return response()->json(['message' => 'Reservation deleted.']);
    }
}
