<?php

namespace App\Girocleta;

use BotMan\BotMan\Messages\Attachments\Location as BotManLocation;

class Location
{

    const EARTH_RADIUS = 6371;
    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude() { return $this->latitude; }

    public function getLongitude() { return $this->longitude; }

    public function getLocationAttachment()
    {
        return new BotManLocation($this->latitude, $this->longitude);
    }

    /**
     * Calculate the distance to the point in kilometers.
     *
     * @param $latitude
     * @param $longitude
     * @return float|int
     */
    public function getDistance(float $latitude, float $longitude)
    {
        $degLat = deg2rad($latitude - $this->latitude);
        $degLon = deg2rad($longitude - $this->longitude);

        $a = sin($degLat/2) * sin($degLat/2) + cos(deg2rad($this->latitude)) * cos(deg2rad($latitude)) * sin($degLon/2) * sin($degLon/2);

        return self::EARTH_RADIUS * (2 * asin(sqrt($a)));
    }
}