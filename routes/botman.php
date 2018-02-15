<?php

$botman = resolve('botman');

$botman->hears('/start|hola|afegir estacio', 'App\Http\Controllers\GirocletaController@welcomeConversation');

$botman->hears('/station|^estaci[ó|o]|quina .* estaci[ó|o]', 'App\Http\Controllers\GirocletaController@checkStation');

$botman->hears('afegir recordatori|/reminder', 'App\Http\Controllers\GirocletaController@reminderConversation');

$botman->hears('/remove|/forget|(?:borrar?|treu(?:re)?|oblidar?) estaci[ó|o]', 'App\Http\Controllers\GirocletaController@forgetStation');