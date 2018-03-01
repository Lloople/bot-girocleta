<?php

$botman = resolve('botman');

$botman->middleware->received(new \App\Http\Middleware\Botman\LoadUserMiddleware());

$botman->hears('/start|hola|afegir estacio', 'App\Http\Controllers\GirocletaController@registerConversation');

$botman->hears('/station|^estaci[ó|o]$|quina .* estaci[ó|o]', 'App\Http\Controllers\GirocletaController@checkStation');

$botman->hears('afegir recordatori|/reminder', 'App\Http\Controllers\GirocletaController@reminderConversation');

$botman->hears('els meus recordatoris|/reminders', 'App\Http\Controllers\GirocletaController@seeReminders');

$botman->hears('/remove|/forget|/delete|(?:borrar?|oblidar?) usuari', 'App\Http\Controllers\GirocletaController@deleteUser');

$botman->receivesLocation('App\Http\Controllers\GirocletaController@nearStations');
