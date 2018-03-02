<?php

namespace App\Http\Middleware\Botman;

use App\Services\UserService;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class LoadUserMiddleware implements Received
{


    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $user = (new UserService())->findOrCreate($bot->getDriver()->getUser($message));

        auth()->login($user);

        return $next($message);
    }
}
