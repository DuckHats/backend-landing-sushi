<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ config('app_texts.emails.reservation_request.subject') }}</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <div style="background-color: #1a1a1a; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">{{ config('app_texts.emails.reservation_request.title') }}</h1>
        </div>
        <div style="padding: 40px 30px; color: #333333;">
            <p style="font-size: 16px; margin-bottom: 30px; color: #555; text-align: center;">{{ config('app_texts.emails.reservation_request.intro') }}</p>
            
            <div style="background-color: #f9f9f9; border: 1px solid #eeeeee; border-radius: 6px; padding: 25px; margin-bottom: 30px;">
                <div style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.client') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;">{{ $reservation->name }}</span>
                </div>
                <div style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.email') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;"><a href="mailto:{{ $reservation->email }}" style="color: #1a1a1a; text-decoration: none;">{{ $reservation->email }}</a></span>
                </div>
                <div style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.phone') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;">{{ $reservation->phone }}</span>
                </div>
                <div style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.persons') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right; font-size: 16px;"><strong>{{ $reservation->persons }}</strong></span>
                </div>
                <div style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.date') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;"><strong>{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</strong></span>
                </div>
                <div style="display: flow-root; margin-bottom: 0px; padding-bottom: 0px; border-bottom: none;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_request.labels.time') }}</span>
                    <span style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;"><strong>{{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}h</strong></span>
                </div>
                
                @if(!empty($reservation->intolerances))
                <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 12px;">
                    <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 5px;">{{ config('app_texts.emails.reservation_request.labels.intolerances') }}</span>
                    <div style="background-color: #fff0f0; border: 1px solid #ffd6d6; border-radius: 4px; padding: 10px; color: #d63031; font-size: 14px;">
                        {{ $reservation->intolerances }}
                    </div>
                </div>
                @endif
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('reservations.accept', ['token' => $reservation->token]) }}" style="display: inline-block; padding: 12px 30px; margin: 0 10px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 14px; background-color: #27ae60; color: #ffffff;">{{ config('app_texts.emails.reservation_request.buttons.accept') }}</a>
                <a href="{{ route('reservations.reject', ['token' => $reservation->token]) }}" style="display: inline-block; padding: 12px 30px; margin: 0 10px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 14px; background-color: #e74c3c; color: #ffffff;">{{ config('app_texts.emails.reservation_request.buttons.reject') }}</a>
            </div>
            
            <p style="font-size: 12px; color: #999; text-align: center; margin-top: 20px;">
                {{ str_replace(':date', \Carbon\Carbon::parse($reservation->expires_at)->format('d/m/Y H:i'), config('app_texts.emails.reservation_request.expiry')) }}
            </p>
        </div>
        <div style="background-color: #f7f7f7; padding: 20px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eaeaea;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ config('app_texts.emails.reservation_request.footer') }}
        </div>
    </div>
</body>
</html>
