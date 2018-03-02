<?php

namespace App\Http\Controllers;

use App\Conversations\DeleteUserConversation;
use BotMan\BotMan\BotMan;

class UsersController extends Controller
{
    /**
     * Forget about the current selected station.
     *
     * @param \BotMan\BotMan\BotMan $bot
     */
    public function deleteUser(BotMan $bot)
    {
        $bot->startConversation(new DeleteUserConversation());
    }
}
