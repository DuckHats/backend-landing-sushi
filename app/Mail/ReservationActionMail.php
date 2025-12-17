<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Services\CalendarService;

class ReservationActionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Reservation $reservation, public string $actionStatus) {}

    public function envelope(): Envelope
    {
        $subject = ($this->actionStatus === 'confirmed')
            ? config('app_texts.emails.reservation_action.subject_confirmed')
            : config('app_texts.emails.reservation_action.subject_rejected');

        return new Envelope(
            subject: $subject . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        $googleCalendarLink = null;
        if ($this->actionStatus === 'confirmed') {
            $googleCalendarLink = app(CalendarService::class)->generateGoogleCalendarLink($this->reservation);
        }

        return new Content(
            view: 'emails.reservation_action',
            with: [
                'googleCalendarLink' => $googleCalendarLink,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
