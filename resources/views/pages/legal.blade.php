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
            <p>El bot ofereix l'opció d'esborrar totes les dades relacionades amb el nostre usuari, només cal dir-li <code>Esborrar usuari</code> i ens demanarà confirmació.</p>
            <p class="text-center">
                <img src="{{ asset('img/screenshots/delete.png') }}" alt="Esborrar usuari">
            </p>

        </div>
    </div>
@endsection