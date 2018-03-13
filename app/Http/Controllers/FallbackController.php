<?php

namespace App\Http\Controllers;

use App\Services\StationService;
use BotMan\BotMan\BotMan;

class FallbackController extends Controller
{
    /** @var \App\Services\StationService */
    protected $stationService;

    const FALLBACK_REPLIES = [
        'No entenc que vols dir 😅',
        'No he trobat cap estació 🤔',
        'Segur que ho has escrit bé? 🙄',
        'M\'ho pots dir d\'una altra manera? 🙇'
    ];

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
            return $bot->randomReply(self::FALLBACK_REPLIES);
        }

        $bot->reply("He trobat la següent estació a partir de \"{$text}\"");
        $bot->reply($station->getVenueMessage(), $station->getVenuePayload());
    }
}
