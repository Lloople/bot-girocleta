@extends('layout')

@section('content')
    <h1 class="mb-8">Sobre el projecte</h1>
    <div class="flex flex-col mb-8 text-left">
        <div class="w-3/5 mx-auto">
            <p>Aquest bot ha estat desenvolupat per <a href="mailto:hello@davidllop.com">David Llop</a>.</p>
            <p>És un projecte Open Source i el codi font es pot trobar al
                <a href="https://github.com/Lloople/bot-girocleta.git" target="_blank">GitHub</a>
                de forma oberta i gratuïta.
            </p>
            <p>És un projecte sense ànim de lucre, i es va desenvolupar per aprenentage i introducció al món dels <code>Chatbots</code>.
            </p>
            <p>Aquest projecte fa servir les següents eines o llibreries</p>
            <ul>
                <li>Laravel PHP Framework 5.6</li>
                <li>BotMan Framework</li>
                <li>Telegram API</li>
                <li>MySQL 5.7</li>
                <li>TailWind CSS</li>
            </ul>
        </div>
    </div>
@endsection