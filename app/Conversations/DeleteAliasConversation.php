<?php

namespace App\Conversations;

use App\Services\StationService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class DeleteAliasConversation extends Conversation
{

    /** @var \App\Services\StationService */
    protected $stationService;

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
        $aliases = auth()->user()->aliases;

        if (! $aliases->count()) {
            return $this->say('De moment no tens cap calias, pots afegir-ne amb /alias');
        }

        $question = Question::create('Quin alias vols esborrar?')
            ->addButtons($aliases->map->asButton()->toArray());

        return $this->ask($question, function (Answer $answer) {

            $this->alias = auth()->user()->aliases()->find($answer->getValue());

            if (! $this->alias) {
                return $this->say("No he trobat l'alias que busques");
            }

            return $this->askConfirmation();
        });
    }

    public function askConfirmation()
    {

        $question = Question::create('⚠️ Estàs segur que vols esborrar aquest alias? Aquesta acció no es pot desfer ⚠️')
            ->addButtons([
                Button::create('Si')->value('si'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {

            $answerValue = $answer->isInteractiveMessageReply() ? $answer->getValue() : $answer->getText();

            if (strtolower($answerValue) == 'si') {

                $this->alias->delete();

                return $this->say("He esborrat l'alias");
            }

            return $this->say("Molt bé, no esborro res per ara.");

        });
    }
}
