<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.reservation_request.subject') }}</title>
</head>

<body
    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #2D0708; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        {{-- Header --}}
        <div
            style="background-color: #722022; background-image: linear-gradient(135deg, #722022 0%, #4a1517 100%); color: #ffffff; padding: 40px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">🔔</div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; color: #EAECDB;">
                {{ config('app_texts.emails.reservation_request.title') }}
            </h1>
        </div>

        {{-- Content --}}
        <div style="padding: 40px; color: #1B1B1E;">
            <p style="font-size: 16px; margin-bottom: 30px; color: #4B5563; text-align: center;">
                {{ config('app_texts.emails.reservation_request.intro') }}</p>

            <div
                style="background-color: #F3F4F6; border-radius: 20px; padding: 30px; margin-bottom: 35px; border: 1px solid #E5E7EB;">
                <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.reservation_request.labels.client') }}</span>
                    <span style="font-size: 15px; color: #111827; font-weight: 600;">{{ $reservation->name }}</span>
                </div>
                <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">Email</span>
                    <span style="font-size: 15px; color: #111827; font-weight: 600;"><a
                            href="mailto:{{ $reservation->email }}"
                            style="color: #722022; text-decoration: none;">{{ $reservation->email }}</a></span>
                </div>
                <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">Teléfono</span>
                    <span style="font-size: 15px; color: #111827; font-weight: 600;">{{ $reservation->phone }}</span>
                </div>
                <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">Fecha
                        y Hora</span>
                    <span
                        style="font-size: 15px; color: #111827; font-weight: 700;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y H:i') }}h</span>
                </div>
                <div style="margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 4px;">Comensales</span>
                    <span
                        style="display: inline-block; background-color: #374151; color: #ffffff; padding: 2px 10px; border-radius: 9999px; font-size: 14px; font-weight: 700;">{{ $reservation->persons }}</span>
                </div>

                @if (!empty($reservation->intolerances))
                    <div style="margin-top: 20px;">
                        <span
                            style="font-size: 11px; color: #DC2626; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 8px;">{{ config('app_texts.emails.reservation_request.labels.intolerances') }}</span>
                        <div
                            style="background-color: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 12px; padding: 15px; color: #991B1B; font-size: 14px; font-weight: 500;">
                            {{ $reservation->intolerances }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div style="text-align: center; margin-top: 40px; display: flex; gap: 10px; justify-content: center;">
                <a href="{{ route('reservations.accept', ['token' => $reservation->token]) }}"
                    style="display: inline-block; background-color: #16A34A; color: #ffffff; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.3);">
                    {{ config('app_texts.emails.reservation_request.buttons.accept') }}
                </a>
                <a href="{{ route('reservations.reject', ['token' => $reservation->token]) }}"
                    style="display: inline-block; background-color: #DC2626; color: #ffffff; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3); margin-left: 10px;">
                    {{ config('app_texts.emails.reservation_request.buttons.reject') }}
                </a>
            </div>

            <p style="font-size: 12px; color: #9CA3AF; text-align: center; margin-top: 30px;">
                {{ str_replace(':date', \Carbon\Carbon::parse($reservation->expires_at)->format('d/m/Y H:i'), config('app_texts.emails.reservation_request.expiry')) }}
            </p>
        </div>

        {{-- Footer --}}
        <div style="background-color: #F9FAFB; padding: 25px; text-align: center; border-top: 1px solid #E5E7EB;">
            <p style="margin: 0; font-size: 12px; color: #9CA3AF;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ config('app_texts.emails.reservation_request.footer') }}
            </p>
        </div>
    </div>
</body>

</html>
