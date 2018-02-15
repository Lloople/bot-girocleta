<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hola|/start', BotManController::class.'@welcomeConversation');
