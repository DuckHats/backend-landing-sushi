Nova sol·licitud de reserva

Nom: {{ $reservation->name }}
Email: {{ $reservation->email }}
Telèfon: {{ $reservation->phone }}
Persones: {{ $reservation->persons }}
Data i hora: {{ $reservation->date_time }}
Intoleràncies: {{ $reservation->intolerances ?? 'Cap' }}

Per acceptar la reserva, fes clic aquí:
{{ route('reservations.accept', ['token' => $reservation->token]) }}

Per rebutjar la reserva, fes clic aquí:
{{ route('reservations.reject', ['token' => $reservation->token]) }}
