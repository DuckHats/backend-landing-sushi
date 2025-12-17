<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class CalendarService
{
    /**
     * Generate a Google Calendar event URL.
     */
    public function generateGoogleCalendarLink(Reservation $reservation): string
    {
        $date = Carbon::parse($reservation->date_time);

        $startTime = $date->format('Ymd\THis');
        $endTime = $date->copy()->addHours(2)->format('Ymd\THis'); // Assume 2 hour duration

        $params = [
            'action' => 'TEMPLATE',
            'text' => 'Reserva Restaurante - ' . $reservation->persons . ' personas',
            'dates' => "{$startTime}/{$endTime}",
            'details' => "Reserva confirmada para {$reservation->persons} personas.\nNombre: {$reservation->name}",
            'location' => config('mail.client.address'),
            'sf' => 'true',
            'output' => 'xml',
        ];

        return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
    }

    /**
     * Generate ICS content.
     */
    public function generateIcsContent(Reservation $reservation): string
    {
        $date = Carbon::parse($reservation->date_time);
        $startTime = $date->format('Ymd\THis');
        $endTime = $date->copy()->addHours(2)->format('Ymd\THis');
        $now = now()->format('Ymd\THis\Z');
        $uuid = $reservation->token . '@' . request()->getHost();

        $description = "Reserva confirmada para {$reservation->persons} personas.";
        $summary = "Reserva Restaurante";
        $location = config('mail.client.address');

        // Escape special characters for ICS
        $description = addcslashes($description, "\n,;\\");
        $summary = addcslashes($summary, "\n,;\\");
        $location = addcslashes($location, "\n,;\\");

        return "BEGIN:VCALENDAR\r\n" .
            "VERSION:2.0\r\n" .
            "PRODID:-//" . config('app.name') . "//NONSGML v1.0//EN\r\n" .
            "CALSCALE:GREGORIAN\r\n" .
            "BEGIN:VEVENT\r\n" .
            "DTSTART;TZID=" . config('app.timezone') . ":{$startTime}\r\n" .
            "DTEND;TZID=" . config('app.timezone') . ":{$endTime}\r\n" .
            "DTSTAMP:{$now}\r\n" .
            "UID:{$uuid}\r\n" .
            "SUMMARY:{$summary}\r\n" .
            "DESCRIPTION:{$description}\r\n" .
            "LOCATION:{$location}\r\n" .
            "END:VEVENT\r\n" .
            "END:VCALENDAR";
    }
}
