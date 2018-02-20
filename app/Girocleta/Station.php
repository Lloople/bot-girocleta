<?php

namespace App\Girocleta;

use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use App\Outgoing\OutgoingMessage;

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

    public function getInfo()
    {
        $text = "{$this->name} | {$this->bikes} 🚲 | ";

        if (isset($this->distance)) {
            $text .= number_format($this->distance, 2).'km';
        }

        return $text;
    }

    public function messageInfo()
    {
        $message = new OutgoingMessage('Aquí tens la informació sobre la teva estació');

        return $message->addLink($this->getInfo(), $this->googleMapsLink());
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

    public function googleMapsImage()
    {
        $token = config('services.google_maps.token');
        return "https://maps.googleapis.com/maps/api/staticmap?key={$token}&markers=color:red|{$this->location->getLatitude()},{$this->location->getLongitude()}&size=360x360&zoom=13";
    }

    public function googleMapsLink()
    {
        return "https://www.google.com/maps/search/?api=1&query={$this->location->getLatitude()},{$this->location->getLongitude()}";
    }

}