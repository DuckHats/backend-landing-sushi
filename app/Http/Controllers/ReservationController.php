<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Services\ReservationService;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    protected ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(StoreReservationRequest $request): JsonResponse
    {
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => config('app_texts.reservation.spam_detected')], 422);
        }

        $reservation = $this->reservationService->placeReservation($request->validated());

        return (new ReservationResource($reservation))
            ->response()
            ->setStatusCode(201);
    }

    public function accept($token)
    {
        $result = $this->reservationService->updateStatus($token, 'confirmed');

        if (isset($result['error']) && $result['error'] === 'not_found') {
            abort(404);
        }

        return view('reservation_feedback', $result['view_data']);
    }

    public function reject($token)
    {
        $result = $this->reservationService->updateStatus($token, 'rejected');

        if (isset($result['error']) && $result['error'] === 'not_found') {
            abort(404);
        }

        return view('reservation_feedback', $result['view_data']);
    }

    public function downloadIcs($token, CalendarService $calendarService)
    {
        $reservation = $this->reservationService->getByToken($token);

        if (!$reservation || $reservation->status !== 'confirmed') {
            abort(404);
        }

        $icsContent = $calendarService->generateIcsContent($reservation);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reserva.ics"');
    }
}
