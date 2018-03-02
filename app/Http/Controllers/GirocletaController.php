<?php

namespace App\Http\Controllers;

use App\Conversations\DeleteUserConversation;
use App\Conversations\RegisterConversation;
use App\Conversations\ReminderConversation;
use App\Girocleta\Station;
use App\Models\Reminder;
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

    public function greetings(BotMan $bot)
    {
        $station = $this->stationService->getUserStation();

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
        $bot->startConversation(new RegisterConversation());
    }

    /**
     * Shows current station information.
     *
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return mixed
     */
    public function checkStation(BotMan $bot)
    {
        $station = $this->stationService->getUserStation();

        if (! $station) {

            return $bot->reply('Sembla que encara no has seleccionat una estació. Escriu /start per fer-ho ara');
        }

        return $bot->reply($station->messageInfo());
    }

    public function tripInformation(BotMan $bot)
    {

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
