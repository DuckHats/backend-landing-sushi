Nova comanda a domicili rebuda!

Detalls del client:
Nom: {{ $order->name }}
Email: {{ $order->email }}
Telèfon: {{ $order->phone }}
Adreça: {{ $order->address }}
Mètode de pagament: {{ $order->payment_method }}

Productes:
@foreach($order->products as $item)
- Producte ID: {{ $item['id'] }} x {{ $item['quantity'] }}
@endforeach

Total estimat: {{ $order->total }} €

Si us plau, prepara la comanda.
