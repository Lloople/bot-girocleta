<?php

namespace App\Girocleta;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Station
{

    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var \App\Girocleta\Location */
    public $location;

    /** @var int */
    public $capacity;

    /** @var int */
    public $bikes;

    public function getFreeSlots()
    {
        return $this->capacity - $this->bikes;
    }

    public static function createFromPayload($payload)
    {
        $station = new Station();

        $station->id = $payload->id;
        $station->name = $payload->name;
        $station->location = new Location($payload->location->lat, $payload->location->lon);
        $station->capacity = $payload->capacity;
        $station->bikes = $payload->bikes;

        return $station;
    }

    public function asButton()
    {
        return Button::create($this->name)->value($this->id);
    }

    public function replyInfo(BotMan $bot)
    {
        $bot->reply("La teva estació és {$this->name}.");
        $bot->reply("Queden {$this->getFreeSlots()} aparcaments lliures.");
        $bot->reply(
            OutgoingMessage::create($this->name)->withAttachment($this->location->getLocationAttachment())
        );
    }

    /**
     * Load distance into location object.
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function withDistanceTo(float $latitude, float $longitude)
    {
        $this->distance = $this->location->getDistance($latitude, $longitude);

        return $this;
    }

}