<?php

namespace App\Http\Controllers;

use App\Conversations\RegisterConversation;
use App\Girocleta\Station;
use App\Outgoing\OutgoingMessage;
use App\Services\StationService;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;

class GirocletaController extends Controller
{

    /** @var \App\Services\StationService */
    protected $stationService;

    public function __construct()
    {
        $this->stationService = app(StationService::class);
    }

    /**
     * Shows current station information.
     *
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return mixed
     */
    public function greetings(BotMan $bot)
    {
        $station = $this->stationService->find(auth()->user()->station_id);

        if ($station === null) {
            return $this->registerConversation($bot);
        }

        $bot->reply("Hola " . auth()->user()->name . "! 👋");
        $bot->reply($station->messageInfo());

    }

    /**
     * Start a conversation to register the user's main station.
     *
     * @param  BotMan $bot
     */
    public function registerConversation(BotMan $bot)
    {
        return $bot->startConversation(new RegisterConversation());
    }

    /**
     * Show information about two stations and their distance.
     *
     * @param \BotMan\BotMan\BotMan $bot
     * @param string $begin
     * @param string $end
     *
     * @return mixed
     */
    public function tripInformation(BotMan $bot, $begin, $end)
    {
        if (! $beginStation = $this->stationService->findByText($begin)) {
            return $bot->reply("No he trobat cap estació semblant a '{$begin}'");
        }

        if (! $endStation = $this->stationService->findByText($end)) {
            return $bot->reply("No he trobat cap estació semblant a '{$end}'");
        }

        if ($beginStation->id === $endStation->id) {
            return $bot->reply("Estàs allà mateix ¯\_(ツ)_/¯");
        }

        $distance = $endStation->location->getDistance(
            $beginStation->location->latitude,
            $beginStation->location->longitude
        );

        $message = new OutgoingMessage("Distancia aprox.: {$distance}km");
        $message->addLink($beginStation->getInfo(), $beginStation->googleMapsLink())
            ->addLink($endStation->getInfo(), $endStation->googleMapsLink());

        return $bot->reply($message);
    }


    /**
     * Show the nearest locations to the user.
     *
     * @param \BotMan\BotMan\BotMan $bot
     * @param \BotMan\BotMan\Messages\Attachments\Location $location
     */
    public function nearStations(BotMan $bot, Location $location)
    {

        $nearStations = $this->stationService->getNearStations($location->getLatitude(), $location->getLongitude());

        $message = new OutgoingMessage("Aquestes són les {$nearStations->count()} estacions que tens més a prop");

        $nearStations->each(function (Station $station) use ($message) {

            $message->addLink($station->getInfo(), $station->googleMapsLink());

        });

        $bot->reply($message);
    }

}
