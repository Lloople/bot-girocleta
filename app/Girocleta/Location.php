<?php

namespace App\Girocleta;

use BotMan\BotMan\Messages\Attachments\Location as BotManLocation;

class Location
{

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLocationAttachment()
    {
        return new BotManLocation($this->latitude, $this->longitude);
    }
}