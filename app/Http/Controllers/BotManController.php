<?php

namespace App\Http\Controllers;

use App\Conversations\WelcomeConversation;
use BotMan\BotMan\BotMan;

class BotManController extends Controller
{

    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     *
     * @param  BotMan $bot
     */
    public function welcomeConversation(BotMan $bot)
    {
        $bot->startConversation(new WelcomeConversation());
    }
}
