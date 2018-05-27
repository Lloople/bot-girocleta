<?php

namespace App\Http\Controllers;

use App\Conversations\RegisterConversation;
use App\Girocleta\Station;
use App\Outgoing\OutgoingMessage;
use App\Services\StationService;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;
use Illuminate\Support\Facades\Log;

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

        return $bot->reply(file_get_contents(resource_path('help.md')), [
            'parse_mode' => 'Markdown'
        ]);
    }

}
