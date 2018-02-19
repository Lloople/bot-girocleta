<?php

namespace App\Conversations;

use App\Services\StationService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;

class RegisterConversation extends Conversation
{

    const STATION_UNKNOWN = 'Em sap greu, però no sé de quina estació es tracta 🤔';

    /** @var \App\Girocleta\Station */
    protected $station;

    /** @var \App\Services\StationService  */
    protected $stationService;

    public function __construct()
    {
        $this->stationService = new StationService();
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $question = Question::create('Hola! Quina estació tens més a prop de casa?')
            ->addButtons($this->stationService->asButtons());

        return $this->ask($question, function (Answer $answer) {

            $this->station = $this->stationService->find($answer->getValue());

            if (! $this->station) {
                return $this->say(self::STATION_UNKNOWN);
            }

            $this->bot->userStorage()->save(['station_id' => $this->station->id]);

            return $this->say($this->station->messageInfo());
        });
    }
}
