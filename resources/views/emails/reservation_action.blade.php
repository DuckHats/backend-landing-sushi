<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $actionStatus === 'confirmed' ? config('app_texts.emails.reservation_action.subject_confirmed') : config('app_texts.emails.reservation_action.subject_rejected') }}</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <div style="background-color: {{ $actionStatus === 'confirmed' ? '#27ae60' : '#e74c3c' }}; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">{{ $actionStatus === 'confirmed' ? config('app_texts.emails.reservation_action.title_confirmed') : config('app_texts.emails.reservation_action.title_rejected') }}</h1>
        </div>
        <div style="padding: 40px 30px; color: #333333; text-align: center;">
            @if($actionStatus === 'confirmed')
                <div style="font-size: 50px; margin-bottom: 20px; display: block;">🎉</div>
                <p style="font-size: 16px; margin-bottom: 30px; color: #555;">{!! str_replace(':name', $reservation->name, config('app_texts.emails.reservation_action.message_confirmed')) !!}</p>
                
                <div style="background-color: #f9f9f9; border: 1px solid #eeeeee; border-radius: 6px; padding: 25px; margin: 30px 0; text-align: left;">
                    <div style="display: flow-root; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_action.labels.day') }}</span>
                        <span style="font-weight: 500; color: #1a1a1a; float: right;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</span>
                    </div>
                    <div style="display: flow-root; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_action.labels.time') }}</span>
                        <span style="font-weight: 500; color: #1a1a1a; float: right;">{{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}h</span>
                    </div>
                    <div style="display: flow-root; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_action.labels.persons') }}</span>
                        <span style="font-weight: 500; color: #1a1a1a; float: right;">{{ $reservation->persons }}</span>
                    </div>
                    <div style="display: flow-root; margin-bottom: 0; padding-bottom: 0;">
                        <span style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_action.labels.address') }}</span>
                        <span style="font-weight: 500; color: #1a1a1a; float: right;">{{ config('mail.client.address') }}</span>
                    </div>
                </div>

                <div style="margin-top: 35px; border-top: 1px solid #eee; padding-top: 25px;">
                    <p style="font-size: 13px; color: #888; margin-bottom: 15px;">{{ config('app_texts.emails.reservation_action.calendar_intro') }}</p>
                    <a href="{{ $googleCalendarLink }}" style="display: inline-block; background-color: #4285F4; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; margin: 5px; font-weight: 500;">📅 Google Calendar</a>
                    <a href="{{ route('reservations.ics', ['token' => $reservation->token]) }}" style="display: inline-block; background-color: #f1f3f4; color: #3c4043; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; margin: 5px; font-weight: 500; border: 1px solid #dadce0;">📅 Outlook / Apple</a>
                </div>
            @else
                <div style="font-size: 50px; margin-bottom: 20px; display: block;">😓</div>
                <p style="font-size: 16px; margin-bottom: 30px; color: #555;">{!! str_replace(':name', $reservation->name, config('app_texts.emails.reservation_action.message_rejected')) !!}</p>
                <p style="color: #666; font-size: 15px;">{{ config('app_texts.emails.reservation_action.message_rejected_sub') }}</p>
                
                <div style="margin-top: 30px;">
                    <a href="tel:+34{{config('mail.client.phone')}}" style="color: #1a1a1a; text-decoration: underline; font-weight: 600;">{{ config('app_texts.emails.reservation_action.contact_button') }}</a>
                </div>
            @endif
        </div>
        <div style="background-color: #f7f7f7; padding: 20px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eaeaea;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ config('app_texts.emails.reservation_action.footer') }}
        </div>
    </div>
</body>
</html>
