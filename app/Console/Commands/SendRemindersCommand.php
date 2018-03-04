<?php

namespace App\Console\Commands;

use App\Drivers\TelegramDriver;
use App\Models\Reminder;
use App\Services\StationService;
use Illuminate\Console\Command;

class SendRemindersCommand extends Command
{

    protected $signature = 'reminders:send';

    protected $description = 'Send the reminders for the current day and time';

    /** @var \App\Services\StationService  */
    protected $stationService;

    /** @var \BotMan\BotMan\BotMan */
    protected $botman;

    public function __construct(StationService $stationService)
    {
        parent::__construct();
        $this->stationService = $stationService;
        $this->botman = resolve('botman');
    }

    public function handle()
    {
        $reminders = $this->getReminders();

        if (! $reminders->count()) {
            return; // no reminders to fire right now
        }

        $reminders->each(function (Reminder $reminder) {

            $station = $this->stationService->find($reminder->station_id);

            if (! $station || ! $reminder->user) {
                return; // corrupted reminder, we need to do something about it
            }

            $this->botman->say($station->messageInfo(), $reminder->user->telegram_id, TelegramDriver::class);
        });
    }

    private function getReminders()
    {
        return Reminder::where('active', true)
            ->where(date('l'), true)
            ->where('time', date('H:i'))
            ->where('date_begin', '<=', date('Y-m-d H:i:s'))
            ->where(function ($dateEnd) {
                return $dateEnd->whereNull('date_end')
                    ->orWhere('date_end', '>=', date('Y-m-d H:i:s'));
            });
    }
}
