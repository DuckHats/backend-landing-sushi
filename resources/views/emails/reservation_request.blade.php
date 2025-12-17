<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .header { background-color: #722022; color: #ffffff; padding: 40px 30px; text-align: center; }
    .header h1 { margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 0.5px; }
    .content { padding: 40px 30px; color: #1B1B1E; line-height: 1.6; }
    .card { background-color: #FAFAFA; border: 1px solid #EAECDB; border-radius: 8px; padding: 25px; margin: 25px 0; }
    .data-row { margin-bottom: 15px; border-bottom: 1px solid #EAECDB; padding-bottom: 10px; display: flex; justify-content: space-between; }
    .data-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .label { font-weight: 600; color: #722022; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
    .value { font-weight: 400; color: #333; text-align: right; }
    .actions { text-align: center; margin-top: 35px; }
    .btn { display: inline-block; padding: 14px 28px; margin: 0 8px; color: #ffffff; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 14px; transition: opacity 0.3s; }
    .btn-accept { background-color: #8A9556; border: 2px solid #8A9556; }
    .btn-reject { background-color: #ffffff; color: #1B1B1E; border: 2px solid #E5E7EB; }
    .footer { background-color: #1B1B1E; padding: 25px; text-align: center; font-size: 12px; color: #666; }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nova Sol·licitud de Reserva</h1>
        </div>
        <div class="content">
            <p style="font-size: 16px; margin-bottom: 25px;">Hola Admin,</p>
            <p>Tens una nova sol·licitud de reserva pendent d'aprovació. Aquí tens els detalls:</p>
            
            <div class="card">
                <div class="data-row">
                    <span class="label">Nom</span>
                    <span class="value">{{ $reservation->name }}</span>
                </div>
                <div class="data-row">
                    <span class="label">Email</span>
                    <span class="value">{{ $reservation->email }}</span>
                </div>
                <div class="data-row">
                    <span class="label">Telèfon</span>
                    <span class="value">{{ $reservation->phone }}</span>
                </div>
                <div class="data-row">
                    <span class="label">Persones</span>
                    <span class="value">{{ $reservation->persons }}</span>
                </div>
                <div class="data-row">
                    <span class="label">Data i Hora</span>
                    <span class="value">{{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="data-row">
                    <span class="label">Intoleràncies</span>
                    <span class="value">{{ $reservation->intolerances ?? 'Cap' }}</span>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('reservations.accept', ['token' => $reservation->token]) }}" class="btn btn-accept">Acceptar Reserva</a>
                <a href="{{ route('reservations.reject', ['token' => $reservation->token]) }}" class="btn btn-reject">Rebutjar</a>
            </div>
            
            <p style="font-size: 13px; color: #999; text-align: center; margin-top: 30px;">
                Aquests enllaços caduquen en 24 hores.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Restaurant App. Tots els drets reservats.
        </div>
    </div>
</body>
</html>
