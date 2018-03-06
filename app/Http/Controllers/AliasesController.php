<?php

namespace App\Http\Controllers;

use App\Conversations\CreateAliasConversation;
use App\Conversations\DeleteAliasConversation;
use App\Models\Alias;
use App\Services\StationService;
use BotMan\BotMan\BotMan;

class AliasesController extends Controller
{

    /** @var \App\Services\StationService */
    protected $stationService;

    public function __construct()
    {
        $this->stationService = app(StationService::class);
    }

    public function index(BotMan $bot)
    {
        $aliases = auth()->user()->aliases;

        if (! $aliases->count()) {
            return $bot->reply('Encara no tens cap alias, pots afegir-ne un amb /alias');
        }

        $bot->reply('Aquests són els teus alias');

        $aliases->each(function (Alias $alias) use ($bot) {
            $bot->reply($alias->getInfo());
        });

    }

    /**
     * Start a conversation to register new reminder.
     *
     * @param \BotMan\BotMan\BotMan $bot
     */
    public function create(BotMan $bot)
    {
        $bot->startConversation(new CreateAliasConversation());
    }

    /**
     * Start a conversation to delete a reminder.
     *
     * @param \BotMan\BotMan\BotMan $bot
     */
    public function destroy(BotMan $bot)
    {
        $bot->startConversation(new DeleteAliasConversation());
    }
}
