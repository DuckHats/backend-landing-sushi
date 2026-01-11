<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.order_summary.subject') }}</title>
</head>

<body
    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: {{ config('customization.colors.tertiary') }}; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: {{ config('customization.colors.white') }}; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
        {{-- Header --}}
        <div style="background-color: {{ config('customization.colors.primary') }}; color: #ffffff; padding: 40px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">🛵</div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; color: {{ config('customization.colors.beige') }};">
                {{ config('app_texts.emails.order_summary.title') }}
            </h1>
            <div style="margin-top: 10px; display: inline-block; background-color: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        {{-- Content --}}
        <div style="padding: 40px; color: {{ config('customization.colors.black') }};">
            {{-- Client Section --}}
            <h3 style="font-size: 14px; font-weight: 700; color: {{ config('customization.colors.primary') }}; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; border-bottom: 2px solid #F3F4F6; padding-bottom: 8px;">
                {{ config('app_texts.emails.order_summary.sections.client_data') }}
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 35px;">
                <div style="margin-bottom: 15px;">
                    <span style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_summary.labels.name') }}</span>
                    <span style="font-size: 15px; font-weight: 600; color: #111827;">{{ $order->name }}</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <span style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_summary.labels.phone') }}</span>
                    <span style="font-size: 15px; font-weight: 600; color: #111827;">{{ $order->phone }}</span>
                </div>
                <div style="margin-bottom: 15px; grid-column: span 2;">
                    <span style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_summary.labels.address') }}</span>
                    <span style="font-size: 15px; font-weight: 600; color: #111827;">{{ $order->address }}</span>
                </div>
                <div style="grid-column: span 2;">
                    <span style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">{{ config('app_texts.emails.order_summary.labels.payment_method') }}</span>
                    <span style="display: inline-block; background-color: #F3F4F6; color: {{ config('customization.colors.primary') }}; padding: 4px 12px; border-radius: 8px; font-size: 13px; font-weight: 700;">
                        {{ $order->payment_method === 'card' ? config('app_texts.emails.order_summary.payment_methods.card') : config('app_texts.emails.order_summary.payment_methods.cash') }}
                    </span>
                </div>
            </div>

            {{-- Order Details Section --}}
            <h3 style="font-size: 14px; font-weight: 700; color: {{ config('customization.colors.primary') }}; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; border-bottom: 2px solid #F3F4F6; padding-bottom: 8px;">
                {{ config('app_texts.emails.order_summary.sections.order_details') }}
            </h3>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <th style="padding: 12px 0; text-align: left; font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700;">{{ config('app_texts.emails.order_summary.labels.product') }}</th>
                        <th style="padding: 12px 0; text-align: center; font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700;">{{ config('app_texts.emails.order_summary.labels.quantity') }}</th>
                        <th style="padding: 12px 0; text-align: right; font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $item)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 16px 0;">
                            <div style="font-weight: 700; color: #111827; font-size: 14px;">{{ $item['name'] }}</div>
                            <div style="font-size: 12px; color: #6B7280; margin-top: 2px;">{{ config('app_texts.emails.order_summary.labels.id') }}: #{{ $item['id'] }} | {{ number_format($item['price'], 2) }}€/u</div>
                        </td>
                        <td style="padding: 16px 0; text-align: center; color: #111827; font-weight: 600;">
                            x{{ $item['quantity'] }}
                        </td>
                        <td style="padding: 16px 0; text-align: right; font-weight: 700; color: #111827;">
                            {{ number_format($item['subtotal'], 2) }}€
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Summary Total --}}
            <div style="background-color: {{ config('customization.colors.secondary') }}; border-radius: 16px; padding: 25px; color: #ffffff; text-align: right;">
                <span style="display: block; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; opacity: 0.9; margin-bottom: 4px;">
                    {{ config('app_texts.emails.order_summary.labels.total') }}
                </span>
                <span style="font-size: 32px; font-weight: 800; display: block; line-height: 1;">
                    {{ number_format($order->total, 2) }} €
                </span>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background-color: {{ config('customization.colors.black') }}; padding: 25px; text-align: center; font-size: 12px; color: #9CA3AF;">
            {{ str_replace([':year', ':brand'], [date('Y'), config('customization.name')], config('app_texts.emails.order_summary.footer')) }}
        </div>
    </div>
</body>

</html>
