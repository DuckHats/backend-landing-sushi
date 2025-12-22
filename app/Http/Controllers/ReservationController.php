<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Mail\ReservationRequestMail;
use App\Mail\ReservationClientReceiptMail;
use App\Mail\ReservationActionMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request): JsonResponse
    {
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => config('app_texts.reservation.spam_detected')], 422);
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

        $adminEmail = config('mail.client.email');
        Mail::to($adminEmail)->send(new ReservationRequestMail($reservation));
        Mail::to($reservation->email)->send(new ReservationClientReceiptMail($reservation));

        return response()->json([
            'message' => config('app_texts.reservation.success'),
            'status' => 'success'
        ], 201);
    }

    public function accept($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->expires_at < now()) {
            return view('reservation_feedback', [
                'title' => config('app_texts.reservation.feedback.expired_title'),
                'message' => config('app_texts.reservation.feedback.expired_message'),
                'icon' => '⏳'
            ]);
        }

        if ($reservation->status !== 'pending') {
            return view('reservation_feedback', [
                'title' => config('app_texts.reservation.feedback.handled_title'),
                'message' => config('app_texts.reservation.feedback.handled_message', ['status' => $reservation->status]),
                'icon' => 'ℹ️'
            ]);
        }

        $reservation->update(['status' => 'confirmed']);

        Mail::to($reservation->email)->send(new ReservationActionMail($reservation, 'confirmed'));

        return view('reservation_feedback', [
            'title' => config('app_texts.reservation.feedback.confirmed_title'),
            'message' => config('app_texts.reservation.feedback.confirmed_message'),
            'icon' => '✅'
        ]);
    }

    public function reject($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->expires_at < now()) {
            return view('reservation_feedback', [
                'title' => config('app_texts.reservation.feedback.expired_title'),
                'message' => config('app_texts.reservation.feedback.expired_message'),
                'icon' => '⏳'
            ]);
        }

        if ($reservation->status !== 'pending') {
            return view('reservation_feedback', [
                'title' => config('app_texts.reservation.feedback.handled_title'),
                'message' => config('app_texts.reservation.feedback.handled_message', ['status' => $reservation->status]),
                'icon' => 'ℹ️'
            ]);
        }

        $reservation->update(['status' => 'rejected']);

        Mail::to($reservation->email)->send(new ReservationActionMail($reservation, 'rejected'));

        return view('reservation_feedback', [
            'title' => config('app_texts.reservation.feedback.rejected_title'),
            'message' => config('app_texts.reservation.feedback.rejected_message'),
            'icon' => '🚫'
        ]);
    }

    public function downloadIcs($token, \App\Services\CalendarService $calendarService)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        if ($reservation->status !== 'confirmed') {
            abort(404);
        }

        $icsContent = $calendarService->generateIcsContent($reservation);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reserva.ics"');
    }
}
