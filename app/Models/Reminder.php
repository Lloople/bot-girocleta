<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Reminder extends Model
{

    const DAYS = [
        'monday' => 'Dilluns',
        'tuesday' => 'Dimarts',
        'wednesday' => 'Dimecres',
        'thursday' => 'Dijous',
        'friday' => 'Divendres',
        'saturday' => 'Dissabte',
        'sunday' => 'Diumenge'
    ];

    const TYPES = [
        'bikes' => 'Bicis lliures',
        'parkings' => 'Aparcaments lliures'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDaysStrAttribute()
    {
        $days = [];

        foreach(self::DAYS as $day => $name) {
            if ($this->$day) {
                $days[] = strtolower($name);
            }
        }

        $imploded = implode(', ', $days);

        return substr_replace($imploded, ' i ', strrpos($imploded, ', '), 2);
    }

    public function getTimeAttribute()
    {
        return date('H:i', strtotime($this->attributes['time']));
    }

    public function getTypeStrAttribute()
    {
        return self::TYPES[$this->type];
    }

    public function setDays(Collection $days)
    {
        $this->monday = $days->has('monday');
        $this->tuesday = $days->has('tuesday');
        $this->wednesday = $days->has('wednesday');
        $this->thursday = $days->has('thursday');
        $this->friday = $days->has('friday');
        $this->saturday = $days->has('saturday');
        $this->sunday = $days->has('sunday');

        return $this;
    }

    public function getTypeText()
    {
        return self::TYPES[$this->type];
    }

    public function getDaysList()
    {
        $message = '';

        foreach(self::DAYS as $day => $translate) {
            $icon = $this->$day ? '✅' : '❌';

            $message .= "{$icon} {$translate}".PHP_EOL;
        }

        return $message;
    }

}
