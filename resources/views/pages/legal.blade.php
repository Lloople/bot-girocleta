@extends('layout')

@section('content')
    <h1 class="mb-8">Informació legal</h1>
    <div class="flex flex-col mb-8 text-left">
        <div class="w-3/5 mx-auto">
            <p>Aquest bot guarda la següent informació de l'usuari:</p>
            <ul class="mb-8">
                <li>Nom d'usuari</li>
                <li>Nom del perfil de Telegram</li>
                <li>Cognom del perfil de Telegram</li>
                <li>Identificador ùnic del perfil de Telegram</li>
            </ul>
            <p>Aquestes dades no es comparteixen amb tercers i són totalment necessàries pel funcionament del bot i
                per oferir una experiència més personalitzada a l'usuari.</p>
            <p>Cap dels missatges que s'envia queda enregistrat de cap manera al servidor on s'allotja el bot, només al
                historial de conversació del dispositiu de l'usuari que l'ha enviat.</p>
            <h1 class="mb-8 text-center">Esborrar les meves dades</h1>
            <p>El bot ofereix l'opció d'esborrar totes les dades relacionades amb el nostre usuari, només cal dir-li
                <code>Esborrar usuari</code> i ens demanarà confirmació.</p>
            <p class="text-center">
                <img src="{{ asset('img/screenshots/delete.png') }}" alt="Esborrar usuari">
            </p>
        
        </div>
    </div>
@endsection