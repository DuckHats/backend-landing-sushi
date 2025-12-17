<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
    .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .header { background-color: {{ $actionStatus === 'confirmed' ? '#8A9556' : '#1B1B1E' }}; color: #ffffff; padding: 40px 30px; text-align: center; }
    .header h1 { margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 0.5px; }
    .content { padding: 40px 30px; color: #1B1B1E; line-height: 1.6; text-align: center; }
    .status-icon { font-size: 48px; margin-bottom: 20px; display: block; }
    .details { background-color: #FAFAFA; border-radius: 8px; padding: 20px; margin: 30px 0; text-align: left; }
    .footer { background-color: #1B1B1E; padding: 25px; text-align: center; font-size: 12px; color: #666; }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reserva {{ $actionStatus === 'confirmed' ? 'Confirmada' : 'Rebutjada' }}</h1>
        </div>
        <div class="content">
            <span class="status-icon">{{ $actionStatus === 'confirmed' ? '✅' : '❌' }}</span>
            
            <p style="font-size: 18px;">Hola {{ $reservation->name }},</p>
            
            @if($actionStatus === 'confirmed')
                <p>Ens complau informar-te que la teva reserva ha estat confirmada correctament.</p>
                
                <div class="details">
                    <p><strong>Dia:</strong> {{ \Carbon\Carbon::parse($reservation->date_time)->format('d/m/Y') }}</p>
                    <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reservation->date_time)->format('H:i') }}</p>
                    <p><strong>Persones:</strong> {{ $reservation->persons }}</p>
                </div>
                
                <p>T'esperem aviat!</p>
            @else
                <p>Ho sentim, però no hem pogut confirmar la teva reserva per a la data sol·licitada.</p>
                <p>Si us plau, posa't en contacte amb nosaltres per cercar una altra disponibilitat.</p>
                <div class="details" style="text-align: center;">
                    <p>📞 Contacte Restaurant</p>
                </div>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Restaurant App. Tots els drets reservats.
        </div>
    </div>
</body>
</html>
