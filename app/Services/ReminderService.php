<?php

namespace App\Services;

use App\Models\Reminder;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Support\Carbon;

class ReminderService
{

    const DAYS_OPTIONS = [
        'all' => 'Tots els dies',
        'weekend' => 'Cap de setmana',
        'weekdays' => 'Entre setmana',
    ];

    public function all()
    {
        return Reminder::TYPES;
    }

    public function asButtons()
    {
        return collect($this->all())->map(function ($text, $reminder) {
            return Button::create($text)->value($reminder);
        })->values()->toArray();
    }

    public function find($reminder)
    {
        if (! array_key_exists($reminder, $this->all())) {
            return null;
        }

        return $this->all()[$reminder];
    }

    public function possibleDaysButtons()
    {
        return collect(self::DAYS_OPTIONS)->map(function ($text, $value) {
            return Button::create($text)->value($value);
        })->toArray();
    }

    public function parseHoursFromInput($input)
    {
        try {
            return Carbon::parse($input)->format('H:i'); // NO VA. Això no va, està agafant la hora actual
        } catch(\Exception $e) {
            return null;
        }
    }

    public function parseDaysFromInput($input)
    {
        if ($input === 'all') {
            return array_keys(Reminder::DAYS);
        }

        if ($input === 'weekend') {
            return collect(Reminder::DAYS)->only('saturday', 'sunday')->keys()->toArray();
        }

        if ($input === 'weekdays') {
            return collect(Reminder::DAYS)->except('saturday', 'sunday')->keys()->toArray();
        }

        return collect(Reminder::DAYS)->filter(function ($day) use ($input) {
            return str_contains(strtolower($input), strtolower($day));
        })->keys()->toArray(); // NO VA. Aquesta casuistica està donant error tota l'estona
    }

}