<?php

namespace App\Http\Controllers;

use App\Services\StationService;
use BotMan\BotMan\BotMan;

class FallbackController extends Controller
{
    /** @var \App\Services\StationService */
    protected $stationService;

    public function __construct()
    {
        $this->stationService = app(StationService::class);
    }

    /**
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return mixed
     */
    public function index(BotMan $bot)
    {
        $text = $bot->getMessage()->getText();

        $station = $this->stationService->findByText($text);

        if (! $station) {
            return $bot->reply('No entenc què vols dir 😅');
        }

        return $bot->reply($station->messageInfo("He trobat la següent estació a partir de '{$text}'"));
    }
}
