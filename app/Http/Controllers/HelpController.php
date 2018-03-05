<?php

namespace App\Http\Controllers;

use App\Conversations\RegisterConversation;
use App\Girocleta\Station;
use App\Outgoing\OutgoingMessage;
use App\Services\StationService;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;

class HelpController extends Controller
{

    /**
     * Shows current station information.
     *
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return mixed
     */
    public function index(BotMan $bot)
    {
        // TODO: Load a markdown file and change the way we send this reply to use Markdown parser
       return $bot->reply('Aquí està la guia per fer servir el bot de la girocleta');

    }

}
