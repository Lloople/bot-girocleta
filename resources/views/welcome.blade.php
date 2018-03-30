<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Girocleta Bot</title>
    
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container mt-8 text-center mx-auto my-0">
    <div class="logo">
        <img src="{{ url('img/bike.png') }}" alt="Girocleta Bike" width=" 300">
    </div>
    <h1>BOT DE TELEGRAM PER LA GIROCLETA</h1>
    <div class="flex flex-wrap mt-8">
        <div class="md:w-1/2">
            <h2 class="mb-8">Escull una estació</h2>
            <p class="md:text-right">
                Pots triar una estació com a <strong>preferida</strong>. D'aquesta manera cada cop que saludis
                el
                bot et donarà la informació en temps real.
            </p>
        </div>
        <div class="md:w-1/2">
            <img src="{{ asset('img/screenshots/start.png') }}" alt="Escull una parada">
        </div>
    </div>
    
    <div class="flex flex-wrap mt-4">
        <div class="md:w-1/2">
            <img src="{{ asset('img/screenshots/reminders.png') }}" alt="Afegeix recordatoris">
        </div>
        <div class="md:w-1/2">
            <h2 class="mb-8">Afegeix recordatoris</h2>
            <div class="md:text-left">
                <p>
                    Amb el Bot de la Girocleta pots crear recordatoris que t'avisaràn automàticament de l'estat
                    de
                    l'estació escollida.
                </p>
                <p>Pots configurar:</p>
                <ul>
                    <li>Quin tipus d'avís vols (Bicis lliures o aparcaments lliures)</li>
                    <li>De quina estació vols veure informació</li>
                    <li>Els dies de la setmana</li>
                    <li>L'hora del dia</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>