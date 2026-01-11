<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app_texts.emails.order_client_receipt.subject') }}</title>
</head>

<body
    style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: {{ config('customization.colors.primary') }}; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; line-height: 1.6;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        {{-- Header --}}
        <div
            style="background-color: {{ config('customization.colors.primary') }}; background-image: linear-gradient(135deg, {{ config('customization.colors.primary') }} 0%, {{ config('customization.colors.black') }} 100%); color: #ffffff; padding: 50px 40px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 10px;">🍣</div>
            <h1
                style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; color: {{ config('customization.colors.beige') }};">
                {{ config('app_texts.emails.order_client_receipt.title') }}
            </h1>
            <p
                style="margin: 10px 0 0; font-size: 16px; opacity: 0.9; color: {{ config('customization.colors.beige') }};">
                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        {{-- Content --}}
        <div style="padding: 40px; color: #1B1B1E;">
            <div style="font-size: 18px; margin-bottom: 30px; color: #333; font-weight: 500;">
                {!! config('app_texts.emails.order_client_receipt.intro') !!}
            </div>

            {{-- Shipping/Payment Details --}}
            <div
                style="background-color: #F9FAFB; border-radius: 16px; padding: 25px; margin-bottom: 35px; border: 1px solid #E5E7EB;">
                <div style="display: flex; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <span
                            style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 6px;">
                            {{ config('app_texts.emails.order_client_receipt.labels.address') }}
                        </span>
                        <span
                            style="font-size: 14px; color: #111827; font-weight: 600; line-height: 1.4;">{{ $order->address }}</span>
                    </div>
                </div>
                <div>
                    <span
                        style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; display: block; margin-bottom: 6px;">
                        {{ config('app_texts.emails.order_client_receipt.labels.payment') }}
                    </span>
                    <span
                        style="display: inline-block; background-color: {{ config('customization.colors.primary') }}; color: #ffffff; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                        {{ $order->payment_method === 'card' ? config('app_texts.emails.order_summary.payment_methods.card') : config('app_texts.emails.order_summary.payment_methods.cash') }}
                    </span>
                </div>
            </div>

            {{-- Products Table --}}
            <h3
                style="font-size: 16px; font-weight: 700; color: {{ config('customization.colors.primary') }}; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; border-bottom: 2px solid #F3F4F6; padding-bottom: 10px;">
                {{ config('app_texts.emails.order_client_receipt.sections.summary') }}
            </h3>

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <th
                            style="padding: 12px 0; text-align: left; font-size: 12px; color: #6B7280; text-transform: uppercase; font-weight: 600;">
                            {{ config('app_texts.emails.order_summary.labels.product') }}</th>
                        <th
                            style="padding: 12px 0; text-align: center; font-size: 12px; color: #6B7280; text-transform: uppercase; font-weight: 600;">
                            {{ config('app_texts.emails.order_summary.labels.quantity') }}</th>
                        <th
                            style="padding: 12px 0; text-align: right; font-size: 12px; color: #6B7280; text-transform: uppercase; font-weight: 600;">
                            Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $item)
                        <tr style="border-bottom: 1px solid #F3F4F6;">
                            <td style="padding: 16px 0;">
                                <div style="font-weight: 700; color: #111827; font-size: 15px;">{{ $item['name'] }}
                                </div>
                                <div style="font-size: 13px; color: #6B7280; margin-top: 2px;">
                                    {{ number_format($item['price'], 2) }}€ / ud.</div>
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

            {{-- Total Section --}}
            <div
                style="margin-top: 30px; background: linear-gradient(to right, {{ config('customization.colors.secondary') }}, {{ config('customization.colors.primary') }}); color: #ffffff; padding: 25px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span
                        style="display: block; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; opacity: 0.9;">
                        {{ config('app_texts.emails.order_client_receipt.labels.total') }}
                    </span>
                    <span style="display: block; font-size: 32px; font-weight: 800; line-height: 1;">
                        {{ number_format($order->total, 2) }} €
                    </span>
                </div>
                <div
                    style="background-color: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 12px; font-size: 14px; font-weight: 600; border: 1px solid rgba(255,255,255,0.3);">
                    {{ config('app_texts.emails.order_client_receipt.status_confirmed') }}
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background-color: #F9FAFB; padding: 30px; text-align: center; border-top: 1px solid #E5E7EB;">
            <p style="margin: 0; font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 8px;">
                {{ config('app_texts.emails.order_client_receipt.footer') }}
            </p>
            <p style="margin: 0; font-size: 12px; color: #9CA3AF;">
                {{ str_replace([':year', ':brand'], [date('Y'), config('customization.name')], config('app_texts.emails.reservation_action.footer')) }}
            </p>
        </div>
    </div>
</body>

</html>
