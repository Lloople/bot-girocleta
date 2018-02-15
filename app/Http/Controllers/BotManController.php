<?php

namespace App\Http\Controllers;

use App\Conversations\ReminderConversation;
use App\Conversations\WelcomeConversation;
use App\Girocleta\StationService;
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
}
