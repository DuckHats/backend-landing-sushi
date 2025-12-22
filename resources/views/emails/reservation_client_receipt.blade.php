<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.reservation_client_receipt.subject') }}</title>
</head>

<body
    style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
        <div style="background-color: #1a1a1a; padding: 30px; text-align: center;">
            <h1
                style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">
                {{ config('app_texts.emails.reservation_client_receipt.title') }}</h1>
        </div>
        <div style="padding: 40px 30px; color: #333333;">
            <p style="font-size: 16px; margin-bottom: 30px; color: #555; text-align: center;">{!! config('app_texts.emails.reservation_client_receipt.intro', ['name' => $reservation->name]) !!}</p>

            <div
                style="background-color: #f9f9f9; border: 1px solid #eeeeee; border-radius: 6px; padding: 25px; margin-bottom: 30px;">
                <div
                    style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span
                        style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_client_receipt.labels.date') }}</span>
                    <span
                        style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;"><strong>{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</strong></span>
                </div>
                <div
                    style="display: flow-root; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <span
                        style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_client_receipt.labels.time') }}</span>
                    <span
                        style="font-weight: 500; color: #1a1a1a; float: right; text-align: right;"><strong>{{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}h</strong></span>
                </div>
                <div style="display: flow-root; margin-bottom: 0px; padding-bottom: 0px; border-bottom: none;">
                    <span
                        style="font-weight: 600; color: #888; font-size: 13px; text-transform: uppercase; float: left;">{{ config('app_texts.emails.reservation_client_receipt.labels.persons') }}</span>
                    <span
                        style="font-weight: 500; color: #1a1a1a; float: right; text-align: right; font-size: 16px;"><strong>{{ $reservation->persons }}</strong></span>
                </div>
            </div>

            <p style="font-size: 14px; color: #777; text-align: center; margin-top: 20px;">
                {{ config('app_texts.emails.reservation_client_receipt.footer') }}
            </p>
        </div>
        <div
            style="background-color: #f7f7f7; padding: 20px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eaeaea;">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        </div>
    </div>
</body>

</html>
