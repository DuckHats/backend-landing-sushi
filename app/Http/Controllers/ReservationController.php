<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Mail\ReservationRequestMail;
use App\Mail\ReservationActionMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request): JsonResponse
    {
        // Honeypot check is handled by validation rules (max:0) or we can double check here
        // If honey_pot field has data, it's a bot.
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => 'Spam detected'], 422);
        }

        $validated = $request->validated();

        $reservation = Reservation::create([
            'name' => strip_tags($validated['name']),
            'email' => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'phone' => strip_tags($validated['phone']),
            'persons' => $validated['persons'],
            'date_time' => $validated['date_time'],
            'intolerances' => isset($validated['intolerances']) ? strip_tags($validated['intolerances']) : null,
            'token' => Str::random(32),
            'expires_at' => now()->addHours(24),
            'status' => 'pending',
        ]);

        // Send email to admin
        // Assuming admin email is configured in .env as MAIL_FROM_ADDRESS or similar, 
        // or we can hardcode a placeholder if not set.
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new ReservationRequestMail($reservation));

        return response()->json([
            'message' => 'Reserva sol·licitada correctament. Rebràs confirmació per email.',
            'status' => 'success'
        ], 201);
    }

    public function accept($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->expires_at < now()) {
            return "Aquesta sol·licitud ha caducat.";
        }

        if ($reservation->status !== 'pending') {
            return "Aquesta reserva ja ha estat gestionada ({$reservation->status}).";
        }

        $reservation->update(['status' => 'confirmed']);

        Mail::to($reservation->email)->send(new ReservationActionMail($reservation, 'confirmed'));

        return "Reserva CONFIRMADA. S'ha enviat un correu al client.";
    }

    public function reject($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->expires_at < now()) {
            return "Aquesta sol·licitud ha caducat.";
        }

        if ($reservation->status !== 'pending') {
            return "Aquesta reserva ja ha estat gestionada ({$reservation->status}).";
        }

        $reservation->update(['status' => 'rejected']);

        Mail::to($reservation->email)->send(new ReservationActionMail($reservation, 'rejected'));

        return "Reserva REBUTJADA. S'ha enviat un correu al client.";
    }
}
