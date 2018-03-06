<?php

namespace App\Conversations;

use App\Models\Alias;
use App\Services\StationService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;

class CreateAliasConversation extends Conversation
{

    /** @var \App\Services\StationService  */
    protected $stationService;

    /** @var string */
    protected $alias;

    /** @var \App\Girocleta\Station */
    protected $station;

    public function __construct()
    {
        $this->stationService = app(StationService::class);
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->ask('Quin alias vols afegir?', function (Answer $answer) {
            $this->alias = $answer->getText();

            $previousAlias = auth()->user()->aliases()->where('alias', 'like', "%{$this->alias}%")->first();

            if ($previousAlias) {
                return $this->say("Ja tens un alias associat a {$this->alias}");
            }

            return $this->askStation();
        });
    }

    public function askStation()
    {
        $question = Question::create('Quina estació vols associar a aquest alias?')->addButtons($this->stationService->asButtons());

        return $this->ask($question, function (Answer $answer) {

            $this->station = $this->stationService->find($answer->getValue());

            if (! $this->station) {
                return $this->say('No sé quina estació és. No puc afegir el alias');
            }

            $alias = new Alias();
            $alias->user_id = auth()->user()->id;
            $alias->station_id = $this->station->id;
            $alias->alias = $this->alias;

            $alias->save();

            return $this->say("He afegit el alias {$this->alias} que fa referència a l'estació {$this->station->name}");
        });
    }
}
