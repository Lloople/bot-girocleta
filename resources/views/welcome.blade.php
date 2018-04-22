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
            <div class="panel-info">
                <h2 class="panel-title">Escull una estació</h2>
                <p>
                    Pots triar una estació com a <strong>preferida</strong>. D'aquesta manera cada cop que saludis
                    el bot et donarà la informació en temps real.
                </p>
                <img src="{{ asset('img/screenshots/start.png') }}" alt="Escull una parada">
            </div>
            <div class="panel-info">
                <h2 class="panel-title">Demana per una estació</h2>
                <p>Pots demanar informació per una estació en concret en qualsevol moment fent servir el nom o una
                    localització propera com un carrer o un lloc emblemàtic</p>
                <p>Junt amb la informació de les bicis disponibles i els parkings lliures, també es mostra la distància
                    que hi ha des de l'estació escollida fins al punt que hem indicat, si l'estació ha estat trobada
                    fent servir una localització propera.</p>
                <img src="{{ asset('img/screenshots/naming.png') }}" alt="Busca estacions per nom">
            
            </div>
        </div>
        <div class="md:w-1/2">
            <div class="panel-info">
                <h2 class="panel-title">Afegeix recordatoris</h2>
                <p>
                    Amb el Bot de la Girocleta pots crear recordatoris que t'avisaràn automàticament de l'estat
                    de l'estació escollida.
                </p>
                <p>Pots configurar:</p>
                <ul class="list-reset text-left ml-8">
                    <li>☑️ Quin tipus d'avís vols (Bicis lliures o aparcaments lliures)</li>
                    <li>☑️ De quina estació vols veure informació</li>
                    <li>☑️ Els dies de la setmana</li>
                    <li>☑️ L'hora del dia</li>
                </ul>
                <img src="{{ asset('img/screenshots/reminders.png') }}" alt="Afegeix recordatoris">
            </div>
        </div>
    </div>
</div>
</body>
</html>