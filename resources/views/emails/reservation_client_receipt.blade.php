<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.reservation_client_receipt.subject') }}</title>
</head>

<body
    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #2D0708; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        {{-- Header --}}
        <div
            style="background-color: #722022; background-image: linear-gradient(135deg, #722022 0%, #4a1517 100%); color: #ffffff; padding: 50px 40px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 10px;">📅</div>
            <h1 style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; color: #EAECDB;">
                {{ config('app_texts.emails.reservation_client_receipt.title') }}
            </h1>
        </div>

        {{-- Content --}}
        <div style="padding: 40px; color: #1B1B1E;">
            <div style="font-size: 18px; margin-bottom: 30px; color: #333; font-weight: 500; text-align: center;">
                {!! config('app_texts.emails.reservation_client_receipt.intro', ['name' => $reservation->name]) !!}
            </div>

            <div
                style="background-color: #F9FAFB; border-radius: 16px; padding: 25px; margin-bottom: 35px; border: 1px solid #E5E7EB;">
                <div style="margin-bottom: 20px; border-bottom: 1px solid #E5E7EB; padding-bottom: 15px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 6px;">
                        {{ config('app_texts.emails.reservation_client_receipt.labels.date') }}
                    </span>
                    <span
                        style="font-size: 18px; color: #111827; font-weight: 700;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</span>
                </div>
                <div style="margin-bottom: 20px; border-bottom: 1px solid #E5E7EB; padding-bottom: 15px;">
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 6px;">
                        {{ config('app_texts.emails.reservation_client_receipt.labels.time') }}
                    </span>
                    <span
                        style="font-size: 18px; color: #111827; font-weight: 700;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}h</span>
                </div>
                <div>
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 6px;">
                        {{ config('app_texts.emails.reservation_client_receipt.labels.persons') }}
                    </span>
                    <span
                        style="display: inline-block; background-color: #722022; color: #ffffff; padding: 6px 16px; border-radius: 9999px; font-size: 16px; font-weight: 700;">
                        {{ $reservation->persons }}
                    </span>
                </div>
            </div>

            <p style="font-size: 14px; color: #6B7280; text-align: center; margin-top: 20px; font-style: italic;">
                {{ config('app_texts.emails.reservation_client_receipt.footer') }}
            </p>
        </div>

        {{-- Footer --}}
        <div style="background-color: #F9FAFB; padding: 30px; text-align: center; border-top: 1px solid #E5E7EB;">
            <p style="margin: 0; font-size: 12px; color: #9CA3AF;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>

</html>
