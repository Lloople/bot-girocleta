<?php

namespace App\Http\Controllers;

use App\Conversations\CreateReminderConversation;
use App\Conversations\DeleteReminderConversation;
use App\Conversations\ReminderConversation;
use App\Models\Reminder;
use App\Services\StationService;
use BotMan\BotMan\BotMan;

class RemindersController extends Controller
{

    /** @var \App\Services\StationService */
    protected $stationService;

    public function __construct()
    {
        $this->stationService = app(StationService::class);
    }

    public function index(BotMan $bot)
    {
        $reminders = auth()->user()->reminders;

        $bot->reply('Aquests són els teus recordatoris');

        $reminders->each(function (Reminder $reminder) use ($bot) {
            $bot->reply(
                "Recorda'm {$reminder->type_str_lower} a {$this->stationService->find($reminder->station_id)->name}" . PHP_EOL .
                "{$reminder->getDaysList()}" . PHP_EOL .
                "a les {$reminder->time}"
            );
        });

    }

    /**
     * Start a conversation to register new reminder.
     *
     * @param \BotMan\BotMan\BotMan $bot
     */
    public function create(BotMan $bot)
    {
        $bot->startConversation(new CreateReminderConversation());
    }

    public function destroy(BotMan $bot)
    {
        $bot->startConversation(new DeleteReminderConversation());
    }
}
