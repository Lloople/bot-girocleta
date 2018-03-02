<?php

$botman = resolve('botman');

$botman->middleware->received(new \App\Http\Middleware\Botman\LoadUserMiddleware());

$botman->hears('/help|^ajuda$|(?:no se )?(?:que fer|com (?:funciona|va))', 'App\Http\Controllers\HelpController@index');

$botman->hears('/station|^estaci[ó|o]$|hola', 'App\Http\Controllers\GirocletaController@greetings');
$botman->hears('/start|(?:afegir|definir|canviar?) estaci[ó|o]', 'App\Http\Controllers\GirocletaController@registerConversation');
$botman->hears('(?:(?:vull)? anar de )?(.*) a (.*)', 'App\Http\Controllers\GirocletaController@tripInformation');
$botman->receivesLocation('App\Http\Controllers\GirocletaController@nearStations');

$botman->hears('/reminders|els meus recordatoris', 'App\Http\Controllers\RemindersController@index');
$botman->hears('/reminder|(?:afegir|definir|crear) recordatori', 'App\Http\Controllers\RemindersController@create');
$botman->hears('/reminderdelete|(?:esborrar?|treu[re]?|oblidar?) recordatori', 'App\Http\Controllers\RemindersController@destroy');

$botman->hears('/remove|/forget|/delete|(?:borrar?|oblidar?) usuari', 'App\Http\Controllers\UsersController@destroy');