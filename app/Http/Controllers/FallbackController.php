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
     * @param string $text
     *
     * @return mixed
     */
    public function fallback(BotMan $bot, string $text)
    {
        $station = $this->getStationFromText($text);

        if (! $station) {
            return $bot->reply('No entenc què vols dir 😅');
        }

        return $bot->reply($station->messageInfo());
    }

    /**
     * @param string $text
     *
     * @return \App\Girocleta\Station|null
     */
    private function getStationFromText(string $text)
    {
        $alias = auth()->user()->alias()->where('alias', 'like', "%{$text}%");

        if ($alias) {
            return $this->stationService->find($alias->station_id);
        }

        return $this->stationService->findByText($text);
    }
}
