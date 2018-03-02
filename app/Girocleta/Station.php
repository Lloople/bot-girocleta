<?php

namespace App\Girocleta;

use App\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class Station
{

    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var \App\Girocleta\Location */
    public $location;

    /** @var int */
    public $parkings;

    /** @var int */
    public $bikes;

    public static function createFromPayload($payload)
    {
        $station = new Station();

        $station->id = $payload['id'];
        $station->name = $payload['name'];
        $station->location = new Location($payload['latitude'], $payload['longitude']);
        $station->parkings = $payload['parkings'];
        $station->bikes = $payload['bikes'];

        return $station;
    }

    public function asButton()
    {
        return Button::create($this->name)->value($this->id);
    }

    public function getInfo()
    {
        $text = '';

        if (isset($this->distance)) {
            $text .= "{$this->distance}km | ";
        }

        $text .= "{$this->bikes} 🚲 | {$this->parkings} 🅿️ - {$this->name}";

        return $text;
    }

    public function messageInfo($text = 'Aquí tens la informació sobre la teva estació')
    {
        $message = new OutgoingMessage($text);

        return $message->addLink($this->getInfo(), $this->googleMapsLink());
    }

    /**
     * Load distance into location object.
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return $this
     */
    public function withDistanceTo(float $latitude, float $longitude)
    {
        $this->distance = $this->location->getDistance($latitude, $longitude);

        return $this;
    }

    public function googleMapsLink()
    {
        return "https://www.google.com/maps/search/?api=1&query={$this->location->getLatitude()},{$this->location->getLongitude()}";
    }

}