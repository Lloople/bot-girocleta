<?php

namespace App\Conversations;

use App\Models\Reminder;
use App\Services\ReminderService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Log;

class ReminderConversation extends Conversation
{

    const REMINDER_UNKNOWN = 'No sé quina acció és aquesta.';

    const CANT_UNDERSTAND = 'Ho sento, però no t\'he entès';

    /** @var \App\Services\ReminderService  */
    protected $reminderService;

    /** @var string */
    protected $reminderType;

    /** @var string */
    protected $reminderTime;

    /** @var string */
    protected $reminderDays;

    public function __construct()
    {
        $this->reminderService = new ReminderService();
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $question = Question::create('Què vols que et recordi?')->addButtons($this->reminderService->asButtons());

        return $this->ask($question, function (Answer $answer) {
            $this->reminderType = $answer->getValue();

            if (! $this->reminderService->find($this->reminderType)) {
                return $this->say(self::REMINDER_UNKNOWN);
            }

            return $this->askTime();
        });
    }

    public function askType()
    {

        $question = Question::create('Què vols que et recordi?')->addButtons($this->reminderService->asButtons());

        return $this->ask($question, function (Answer $answer) {
            $this->reminderType = $answer->getValue();

            if (! $this->reminderService->find($this->reminderType)) {
                return $this->say(self::REMINDER_UNKNOWN);
            }

            return $this->askTime();
        });
    }

    public function askTime()
    {
        return $this->ask('A quina hora vols que t\'ho recordi?', function (Answer $answer) {

            $this->reminderTime = $this->reminderService->parseHoursFromInput($answer->getValue());

            if (! $this->reminderTime) {
                return $this->say("No he entès la hora a la que vols que t'ho recordi, prova a escriure-ho així: ".date('H:i'));
            }

            return $this->askDays();
        });
    }

    public function askDays()
    {
        $question = Question::create('Quins dies vols que t\'ho recordi? Si vols dies saltejats, escriu-los en comptes de triar un botó')
            ->addButtons($this->reminderService->possibleDaysButtons());

        return $this->ask($question, function (Answer $answer) {

            $this->reminderDays = $this->reminderService->parseDaysFromInput($answer->getValue());

            if (! $this->reminderDays->count()) {
                return $this->say('Em sap greu, però no he entès quins dies vols que t\'ho recordi');
            }

            $reminder = $this->createReminder();

            $this->say('Molt bé! Això era tot el que necessitàvem, aquest és el teu nou recordatori:');

            $this->say("Recorda'm {$reminder->type_str} el {$reminder->days_str} a les {$reminder->time}");

            $this->createReminder();
        });
    }

    public function createReminder()
    {
        $reminder = new Reminder();
        $reminder->user_id = $this->bot->getUser()->getId();
        $reminder->type = $this->reminderType;
        $reminder->time = $this->reminderTime;


        $reminder->monday = $this->reminderDays->has('monday');
        $reminder->tuesday = $this->reminderDays->has('tuesday');
        $reminder->wednesday = $this->reminderDays->has('wednesday');
        $reminder->thursday = $this->reminderDays->has('thursday');
        $reminder->friday = $this->reminderDays->has('friday');
        $reminder->saturday = $this->reminderDays->has('saturday');
        $reminder->sunday = $this->reminderDays->has('sunday');

        $reminder->save();

        return $reminder;
    }
}
