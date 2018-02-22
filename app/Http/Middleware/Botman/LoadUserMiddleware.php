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

        // TODO: This doesn't work: Error retrieving user info: Bad Request: wrong user_id specified
        $user = (new UserService())->findOrCreate($bot->getUser());

        auth()->login($user);

        return $next($message);
    }
}
