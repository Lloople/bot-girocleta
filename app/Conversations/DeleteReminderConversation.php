<?php

namespace App\Conversations;

use App\Models\Reminder;
use App\Services\ReminderService;
use App\Services\StationService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;

class DeleteReminderConversation extends Conversation
{

    const REMINDER_UNKNOWN = 'No he trobat el recordatori.';

    const CANT_UNDERSTAND = 'Ho sento, però no t\'he entès';

    /** @var \App\Services\ReminderService  */
    protected $reminderService;


    /** @var \App\Services\StationService  */
    protected $stationService;

    /** @var string */
    protected $reminderType;

    /** @var \App\Girocleta\Station */
    protected $reminderStation;

    /** @var \Illuminate\Support\Carbon */
    protected $reminderTime;

    /** @var \Illuminate\Support\Collection */
    protected $reminderDays;

    public function __construct()
    {
        $this->reminderService = new ReminderService();
        $this->stationService = app(StationService::class);
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $question = Question::create('Quin recordatori vols esborrar?')
            ->addButtons(auth()->user()->reminders->map->asButton());

        return $this->ask($question, function (Answer $answer) {

            $this->reminder = auth()->user()->reminders()->find($answer->getValue());

            if (! $this->reminder) {
                return $this->say(self::REMINDER_UNKNOWN);
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

                $this->say("He esborrat el recordatori");
            } else {
                $this->say("El recordatori continuarà actiu una mica més 🙂");
            }
        });
    }
}
