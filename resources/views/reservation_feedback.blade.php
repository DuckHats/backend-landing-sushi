<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; color: #333; }
        .card { background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center; max-width: 450px; width: 90%; }
        .icon { font-size: 60px; margin-bottom: 20px; }
        h1 { margin: 0 0 15px 0; color: #1B1B1E; font-size: 24px; }
        p { color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #1B1B1E; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: background-color 0.2s; }
        .btn:hover { background-color: #333; }
        .success { color: #8A9556; }
        .error { color: #EF4444; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">{{ $icon }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        <a href="/" class="btn">{{ config('app_texts.reservation.feedback.back_to_home') }}</a>
    </div>
</body>
</html>
