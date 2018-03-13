<?php

namespace App\Girocleta;

use App\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Location as BotManLocation;
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

    /** @var string */
    public $foundBy;

    public static function createFromPayload($payload)
    {
        $station = new Station();

        $station->id = $payload['id'];
        $station->name = $payload['name'];
        $station->location = new Location($payload['latitude'], $payload['longitude']);
        $station->parkings = $payload['parkings'];
        $station->bikes = $payload['bikes'];

        return $station->foundById();
    }

    public function asButton()
    {
        return Button::create($this->name)->value($this->id);
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

    public function foundById()
    {
        $this->foundBy = 'id';

        return $this;
    }

    public function foundByText()
    {
        $this->foundBy = 'text';

        return $this;
    }

    public function foundByAlias()
    {
        $this->foundBy = 'alias';

        return $this;
    }

    public function foundByAddress()
    {
        $this->foundBy = 'address';

        return $this;
    }

    public function foundByLocation()
    {
        $this->foundBy = 'location';

        return $this;
    }

    public function wasFoundBy($found)
    {
        return $this->foundBy == $found;
    }

    public function getVenueMessage()
    {
        $message = new OutgoingMessage();

        $message->withAttachment(new BotManLocation($this->location->latitude, $this->location->longitude));

        return $message;
    }

    public function getVenuePayload()
    {
        return [
            'title'   => $this->name,
            'address' => $this->getVenueAddress(),
        ];
    }

    public function getVenueAddress()
    {
        $text = "{$this->bikes} 🚲 - {$this->parkings} 🅿️";

        if (isset($this->distance)) {
            $text .= " - {$this->distance}km";
        }

        return $text;
    }

}