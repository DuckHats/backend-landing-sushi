<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.order_client_receipt.subject') }}</title>
</head>

<body
    style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <div style="background-color: #722022; color: #ffffff; padding: 40px 30px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">🍣
                {{ config('app_texts.emails.order_client_receipt.title') }}</h1>
        </div>
        <div style="padding: 40px 30px; color: #1B1B1E;">
            <p style="font-size: 16px; margin-bottom: 30px; color: #555;">{!! config('app_texts.emails.order_client_receipt.intro', ['name' => $order->name]) !!}</p>

            <div
                style="color: #722022; font-size: 16px; font-weight: 700; border-bottom: 2px solid #EAECDB; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px; text-transform: uppercase;">
                {{ config('app_texts.emails.order_client_receipt.sections.details') }}
            </div>

            <div style="margin-bottom: 10px;">
                <span
                    style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_client_receipt.labels.address') }}</span>
                <span style="font-size: 16px; font-weight: 500; color: #1B1B1E;">{{ $order->address }}</span>
            </div>
            <div style="margin-bottom: 10px;">
                <span
                    style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_client_receipt.labels.payment') }}</span>
                <span style="font-size: 16px; text-transform: uppercase; font-weight: 700; color: #722022;">
                    {{ $order->payment_method === 'card_on_delivery' ? config('app_texts.emails.order_summary.payment_methods.card') : config('app_texts.emails.order_summary.payment_methods.cash') }}
                </span>
            </div>

            <div
                style="color: #722022; font-size: 16px; font-weight: 700; border-bottom: 2px solid #EAECDB; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px; text-transform: uppercase;">
                {{ config('app_texts.emails.order_client_receipt.sections.summary') }}
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr>
                        <th width="70%"
                            style="text-align: left; color: #888; font-size: 12px; padding: 10px; border-bottom: 1px solid #eee;">
                            {{ config('app_texts.emails.order_summary.labels.product') }}</th>
                        <th width="30%"
                            style="text-align: center; color: #888; font-size: 12px; padding: 10px; border-bottom: 1px solid #eee;">
                            {{ config('app_texts.emails.order_summary.labels.quantity') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $item)
                        <tr>
                            <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5;">
                                <strong>{{ config('app_texts.emails.order_summary.labels.product') }}
                                    #{{ $item['id'] }}</strong></td>
                            <td style="text-align: center; padding: 15px 10px; border-bottom: 1px solid #f5f5f5;">
                                x{{ $item['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div
                style="background-color: #8A9556; color: white; padding: 20px; border-radius: 8px; margin-top: 30px; text-align: right;">
                <div style="font-size: 14px; opacity: 0.9;">
                    {{ config('app_texts.emails.order_client_receipt.labels.total') }}</div>
                <div style="font-size: 24px; font-weight: 700;">{{ number_format($order->total, 2) }} €</div>
            </div>
        </div>
        <div style="background-color: #1B1B1E; padding: 25px; text-align: center; font-size: 12px; color: #666;">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
            {{ config('app_texts.emails.order_client_receipt.footer') }}
        </div>
    </div>
</body>

</html>
