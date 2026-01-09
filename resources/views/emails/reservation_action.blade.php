<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $actionStatus === 'confirmed' ? config('app_texts.emails.reservation_action.subject_confirmed') : config('app_texts.emails.reservation_action.subject_rejected') }}</title>
</head>

<body
    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #2D0708; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        {{-- Header --}}
        <div
            style="background-color: {{ $actionStatus === 'confirmed' ? '#16A34A' : '#DC2626' }}; background-image: linear-gradient(135deg, {{ $actionStatus === 'confirmed' ? '#16A34A 0%, #15803d 100%' : '#DC2626 0%, #991B1B 100%' }}); color: #ffffff; padding: 50px 40px; text-align: center;">
            <div style="font-size: 50px; margin-bottom: 15px;">{{ $actionStatus === 'confirmed' ? '🎉' : '😓' }}</div>
            <h1 style="margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; color: #EAECDB;">
                {{ $actionStatus === 'confirmed' ? config('app_texts.emails.reservation_action.title_confirmed') : config('app_texts.emails.reservation_action.title_rejected') }}
            </h1>
        </div>

        {{-- Content --}}
        <div style="padding: 40px; color: #1B1B1E; text-align: center;">
            <p style="font-size: 18px; margin-bottom: 30px; color: #333; font-weight: 500;">
                {!! str_replace(':name', $reservation->name, $actionStatus === 'confirmed' ? config('app_texts.emails.reservation_action.message_confirmed') : config('app_texts.emails.reservation_action.message_rejected')) !!}
            </p>

            @if ($actionStatus === 'confirmed')
                <div
                    style="background-color: #F9FAFB; border-radius: 20px; padding: 30px; margin: 30px 0; text-align: left; border: 1px solid #E5E7EB;">
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                        <span
                            style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.reservation_action.labels.day') }}</span>
                        <span
                            style="font-size: 16px; color: #111827; font-weight: 700;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</span>
                    </div>
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                        <span
                            style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.reservation_action.labels.time') }}</span>
                        <span
                            style="font-size: 16px; color: #111827; font-weight: 700;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}h</span>
                    </div>
                    <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                        <span
                            style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.reservation_action.labels.persons') }}</span>
                        <span
                            style="display: inline-block; background-color: #722022; color: #ffffff; padding: 2px 10px; border-radius: 9999px; font-size: 14px; font-weight: 700;">{{ $reservation->persons }}</span>
                    </div>
                    <div>
                        <span
                            style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.reservation_action.labels.address') }}</span>
                        <span
                            style="font-size: 14px; color: #111827; font-weight: 600;">{{ config('mail.client.address') }}</span>
                    </div>
                </div>

                {{-- Calendar Integration --}}
                <div style="margin-top: 35px; border-top: 2px dashed #E5E7EB; padding-top: 30px;">
                    <p style="font-size: 14px; color: #6B7280; margin-bottom: 20px; font-style: italic;">
                        {{ config('app_texts.emails.reservation_action.calendar_intro') }}</p>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="{{ $googleCalendarLink }}"
                            style="display: inline-block; background-color: #4285F4; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(66, 133, 244, 0.3);">
                            📅 Google Calendar
                        </a>
                        <a href="{{ route('reservations.ics', ['token' => $reservation->token]) }}"
                            style="display: inline-block; background-color: #ffffff; color: #374151; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; border: 2px solid #E5E7EB; margin-left: 10px;">
                            📅 Apple / Outlook
                        </a>
                    </div>
                </div>
            @else
                <p style="color: #6B7280; font-size: 16px; margin: 30px 0;">
                    {{ config('app_texts.emails.reservation_action.message_rejected_sub') }}</p>

                <div style="margin-top: 40px;">
                    <a href="tel:+34{{ config('mail.client.phone') }}"
                        style="display: inline-block; background-color: #722022; color: #ffffff; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; box-shadow: 0 4px 14px rgba(114, 32, 34, 0.3);">
                        {{ config('app_texts.emails.reservation_action.contact_button') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div style="background-color: #F9FAFB; padding: 30px; text-align: center; border-top: 1px solid #E5E7EB;">
            <p style="margin: 0; font-size: 12px; color: #9CA3AF;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ config('app_texts.emails.reservation_action.footer') }}
            </p>
        </div>
    </div>
</body>

</html>
