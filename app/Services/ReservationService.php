<?php

namespace App\Services;

use App\Models\Reservation;
use App\Mail\ReservationRequestMail;
use App\Mail\ReservationClientReceiptMail;
use App\Mail\ReservationActionMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ReservationService
{
    /**
     * Place a new reservation.
     */
    public function placeReservation(array $data): Reservation
    {
        $reservation = Reservation::create([
            'name' => strip_tags($data['name']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'phone' => strip_tags($data['phone']),
            'persons' => $data['persons'],
            'date_time' => $data['date_time'],
            'intolerances' => isset($data['intolerances']) ? strip_tags($data['intolerances']) : null,
            'token' => Str::random(32),
            'expires_at' => now()->addHours(24),
            'status' => 'pending',
        ]);

        $this->sendPlacementEmails($reservation);

        return $reservation;
    }

    /**
     * Process a status update (confirm/reject).
     * Returns an array with 'success' and 'message_key' or 'view_data'.
     */
    public function updateStatus(string $token, string $status): array
    {
        $reservation = Reservation::where('token', $token)->first();

        if (!$reservation) {
            return ['error' => 'not_found'];
        }

        if ($reservation->expires_at < now()) {
            return [
                'error' => 'expired',
                'view_data' => [
                    'title' => config('app_texts.reservation.feedback.expired_title'),
                    'message' => config('app_texts.reservation.feedback.expired_message'),
                    'icon' => '⏳'
                ]
            ];
        }

        if ($reservation->status !== 'pending') {
            return [
                'error' => 'already_handled',
                'view_data' => [
                    'title' => config('app_texts.reservation.feedback.handled_title'),
                    'message' => config('app_texts.reservation.feedback.handled_message', ['status' => $reservation->status]),
                    'icon' => 'ℹ️'
                ]
            ];
        }

        $reservation->update(['status' => $status]);

        Mail::to($reservation->email)->send(new ReservationActionMail($reservation, $status));

        $feedbackConfig = $status === 'confirmed' ? 'confirmed' : 'rejected';
        return [
            'success' => true,
            'view_data' => [
                'title' => config("app_texts.reservation.feedback.{$feedbackConfig}_title"),
                'message' => config("app_texts.reservation.feedback.{$feedbackConfig}_message"),
                'icon' => $status === 'confirmed' ? '✅' : '🚫'
            ]
        ];
    }

    /**
     * Get a reservation by token.
     */
    public function getByToken(string $token): ?Reservation
    {
        return Reservation::where('token', $token)->first();
    }

    /**
     * Send initial reservation emails.
     */
    protected function sendPlacementEmails(Reservation $reservation): void
    {
        $adminEmail = config('customization.email');
        Mail::to($adminEmail)->send(new ReservationRequestMail($reservation));
        Mail::to($reservation->email)->send(new ReservationClientReceiptMail($reservation));
    }
}
