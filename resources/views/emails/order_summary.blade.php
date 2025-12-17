<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .header { background-color: #722022; color: #ffffff; padding: 40px 30px; text-align: center; }
    .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
    .content { padding: 40px 30px; color: #1B1B1E; line-height: 1.6; }
    .section-title { color: #722022; font-size: 16px; font-weight: 700; border-bottom: 2px solid #EAECDB; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px; text-transform: uppercase; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .info-item { margin-bottom: 10px; }
    .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
    .value { font-size: 16px; font-weight: 500; color: #1B1B1E; }
    .product-list { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .product-list th { text-align: left; color: #888; font-size: 12px; padding: 10px; border-bottom: 1px solid #eee; }
    .product-list td { padding: 15px 10px; border-bottom: 1px solid #f5f5f5; }
    .product-list tr:last-child td { border-bottom: none; }
    .total-section { background-color: #8A9556; color: white; padding: 20px; border-radius: 8px; margin-top: 30px; text-align: right; }
    .total-label { font-size: 14px; opacity: 0.9; }
    .total-amount { font-size: 24px; font-weight: 700; }
    .footer { background-color: #1B1B1E; padding: 25px; text-align: center; font-size: 12px; color: #666; }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛵 Nova Comanda a Domicili</h1>
        </div>
        <div class="content">
            <div class="section-title">Dades del Client</div>
            
            <div class="info-item">
                <span class="label">Nom</span>
                <span class="value">{{ $order->name }}</span>
            </div>
            <div class="info-item">
                <span class="label">Email</span>
                <span class="value">{{ $order->email }}</span>
            </div>
            <div class="info-item">
                <span class="label">Telèfon</span>
                <span class="value">{{ $order->phone }}</span>
            </div>
            <div class="info-item">
                <span class="label">Adreça d'Entrega</span>
                <span class="value">{{ $order->address }}</span>
            </div>
            <div class="info-item">
                <span class="label">Mètode de Pagament</span>
                <span class="value" style="text-transform: uppercase; font-weight: 700; color: #722022;">
                    {{ $order->payment_method === 'card_on_delivery' ? 'Targeta (Tarrina)' : 'Efectiu' }}
                </span>
            </div>

            <div class="section-title">Detall de la Comanda</div>
            
            <table class="product-list">
                <thead>
                    <tr>
                        <th width="70%">Producte</th>
                        <th width="15%" style="text-align: center;">Qt.</th>
                        <th width="15%" style="text-align: right;">ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $item)
                    <tr>
                        <td><strong>Producte #{{ $item['id'] }}</strong></td>
                        <td style="text-align: center;">x{{ $item['quantity'] }}</td>
                        <td style="text-align: right;">#{{ $item['id'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-label">Total Estimat</div>
                <div class="total-amount">{{ number_format($order->total, 2) }} €</div>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Restaurant App.
        </div>
    </div>
</body>
</html>
