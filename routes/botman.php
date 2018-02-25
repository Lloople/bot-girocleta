<?php

$botman = resolve('botman');

$botman->middleware->received(new \App\Http\Middleware\Botman\LoadUserMiddleware());

$botman->hears('user', function (\BotMan\BotMan\BotMan $bot) {
    $bot->reply("Hello ".auth()->user()->username);
});

$botman->hears('/start|hola|afegir estacio', 'App\Http\Controllers\GirocletaController@registerConversation');

$botman->hears('/station|^estaci[ó|o]|quina .* estaci[ó|o]', 'App\Http\Controllers\GirocletaController@checkStation');

$botman->hears('afegir recordatori|/reminder', 'App\Http\Controllers\GirocletaController@reminderConversation');

$botman->hears('els meus recordatoris|/reminders', 'App\Http\Controllers\GirocletaController@seeReminders');


$botman->hears('/remove|/forget|(?:borrar?|treu(?:re)?|oblidar?) estaci[ó|o]', 'App\Http\Controllers\GirocletaController@forgetStation');

$botman->receivesLocation('App\Http\Controllers\GirocletaController@nearStations');
