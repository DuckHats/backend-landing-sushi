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
            'text' => config('app_texts.calendar.event_title') . ' - ' . $reservation->persons . ' personas',
            'dates' => "{$startTime}/{$endTime}",
            'details' => str_replace([':persons', ':name'], [$reservation->persons, $reservation->name], config('app_texts.calendar.event_description')),
            'location' => config('customization.address'),
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

        $description = str_replace(':persons', $reservation->persons, config('app_texts.calendar.ics_description'));
        $summary = config('app_texts.calendar.event_title');
        $location = config('customization.address');

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
