Hola {{ $reservation->name }},

La teva reserva ha estat {{ $actionStatus === 'confirmed' ? 'CONFIRMADA' : 'REBUTJADA' }}.

Detalls:
Dia: {{ $reservation->date_time }}
Persones: {{ $reservation->persons }}

@if($actionStatus === 'rejected')
Si us plau, posa't en contacte amb nosaltres trucant al restaurant.
@endif

Gràcies.
