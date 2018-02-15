<?php

namespace App\Http\Controllers;

use App\Conversations\ReminderConversation;
use App\Conversations\WelcomeConversation;
use App\Girocleta\StationService;
use BotMan\BotMan\BotMan;

class GirocletaController extends Controller
{

    /**
     * Start a conversation to register the user's main station.
     *
     * @param  BotMan $bot
     */
    public function welcomeConversation(BotMan $bot)
    {
        $bot->startConversation(new WelcomeConversation());
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

        $station->getInfo($bot);
    }

    /**
     * Forget about the current selected station.
     *
     * @param \BotMan\BotMan\BotMan $bot
     * @return mixed
     */
    public function forgetStation(BotMan $bot)
    {
        $bot->userStorage()->save(['station_id' => null]);

        $bot->reply("He oblidat quina era la teva estació seleccionada 😅");

        return $bot->reply("Els recordatoris deixaran de funcionar fins que en tornis a escollir una amb /start");
    }
}
