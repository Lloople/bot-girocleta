<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getTypeStrAttribute()
    {
        return self::TYPES[$this->type];
    }
}
