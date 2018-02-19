<?php

namespace App\Http\Controllers;

use App\Conversations\ReminderConversation;
use App\Conversations\RegisterConversation;
use App\Girocleta\Station;
use App\Services\StationService;
use App\Outgoing\OutgoingMessage;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;

class GirocletaController extends Controller
{

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
     * Start a conversation to register new reminder.
     *
     * @param \BotMan\BotMan\BotMan $bot
     */
    public function reminderConversation(BotMan $bot)
    {
        $bot->startConversation(new ReminderConversation());
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
        $stationService = new StationService();

        $station = $stationService->find($bot->userStorage()->get('station_id'));

        if (! $station) {

            return $bot->reply('Sembla que encara no has seleccionat una estació. Escriu /start per fer-ho ara');
        }

        return $bot->reply($station->messageInfo());
    }

    /**
     * Forget about the current selected station.
     *
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return mixed
     */
    public function forgetStation(BotMan $bot)
    {
        $bot->userStorage()->save(['station_id' => null]);

        $bot->reply("He oblidat quina era la teva estació seleccionada 😅");

        return $bot->reply("Els recordatoris deixaran de funcionar fins que en tornis a escollir una amb /start");
    }

    /**
     * Show the nearest locations to the user.
     *
     * @param \BotMan\BotMan\BotMan $bot
     * @param \BotMan\BotMan\Messages\Attachments\Location $location
     */
    public function nearStations(BotMan $bot, Location $location)
    {
        $stationService = new StationService();

        $nearStations = $stationService->getNearStations($location->getLatitude(), $location->getLongitude());

        $message = new OutgoingMessage("Aquestes són les {$nearStations->count()} estacions que tens més a prop");

        $nearStations->each(function (Station $station) use ($message) {

            $message->addLink($station->getInfo(), $station->googleMapsLink());

        });

        $bot->reply($message);
    }
}
