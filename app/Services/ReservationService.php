<?php

namespace App\Services;

class ReservationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data): Reservation
    {
        return Reservation::create([
            'user_id' => auth()->id(),
            'event_id' => $data['event_id'],
            'seats' => $data['seats'],
        ]);
    }

    public function update(Reservation $reservation, array $data): Reservation
    {
        $reservation->update($data);

        return $reservation->fresh()->load('event');
    }

    public function delete(Reservation $reservation): void
    {
        $reservation->delete();
    }
}
