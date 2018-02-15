<?php

namespace App\Conversations;

use App\Girocleta\Station;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;

class WelcomeConversation extends Conversation
{

    protected $station = null;
    protected $stations = null;

    public function __construct()
    {
        $this->stations = (new Station())->all();
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {

        $buttons = $this->stations->map(function ($station) {
            return Button::create($station->name)->value($station->id);
        })->toArray();

        $question = Question::create('Hola! Comencem pel principi, quina estació tens més a prop de casa?')
            ->fallback('Em sap greu, però no sé de quina estació es tracta 🤔')
            ->callbackId('register_station')
            ->addButtons($buttons);

        return $this->ask($question, function (Answer $answer) {

            $this->station = $this->stations->where('id', $answer->getValue())->first();

            if (! $this->station) {
                return $this->say('Em sap greu, però no sé de quina estació es tracta 🤔');
            }

            $this->bot->userStorage()->save(['station_id' => $this->station->id]);

            $this->say("La teva parada és {$this->station->name}");
            $this->say(
                OutgoingMessage::create($this->station->name)
                    ->withAttachment(new Location(
                        $this->station->location->lat,
                        $this->station->location->lon)
                    )
            );
        });
    }

    protected function getStationFromStorage()
    {
        return $this->stations->where('id', $this->bot->userStorage()->get('station_id'))->first();
    }

}
