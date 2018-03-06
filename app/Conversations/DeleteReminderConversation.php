<?php

namespace App\Conversations;

use App\Services\StationService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class DeleteReminderConversation extends Conversation
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
        $reminders = auth()->user()->reminders;

        if (! $reminders->count()) {
            return $this->say('De moment no tens recordatoris, pots afegir-ne amb /reminder');
        }

        $question = Question::create('Quin recordatori vols esborrar?')
            ->addButtons($reminders->map->asButton()->toArray());

        return $this->ask($question, function (Answer $answer) {

            $this->reminder = auth()->user()->reminders()->find($answer->getValue());

            if (! $this->reminder) {
                return $this->say('No he trobat el recordatori.');
            }

            return $this->askConfirmation();
        });
    }

    public function askConfirmation()
    {

        $question = Question::create('⚠️ Estàs segur que vols esborrar aquest recordatori? Aquesta acció no es pot desfer ⚠️')
                ->addButtons([
                    Button::create('Si')->value('si'),
                    Button::create('No')->value('no'),
                ]);

        return $this->ask($question, function (Answer $answer) {

            $answerValue = $answer->isInteractiveMessageReply() ? $answer->getValue() : $answer->getText();

            if (strtolower($answerValue) == 'si') {

                $this->reminder->delete();

                return $this->say("He esborrat el recordatori");
            }

            return $this->say("El recordatori continuarà actiu una mica més 🙂");
        });
    }
}
