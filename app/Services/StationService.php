<?php

namespace App\Services;

use App\Girocleta\Station;

class StationService
{

    private $stations;

    const REGEX_LOCATION = '/addMarker\(\d+,(\-?\d+(?:\.\d+)?,\s*\-?\d+(?:\.\d+)?),\d+,\d+\);/';
    const REGEX_STATION = "/html\[\d+\]=\'<div.*>(?P<id>[0-9]+)- ?(?<name>.*)<\/div><div>.*<\/div><div>Bicis lliures: (?<bikes>\d+).*Aparcaments lliures: (?<parkings>\d+).*\';/";

    /**
     * Load all the station just one time per instance.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        if (! $this->stations) {
            $this->stations = collect($this->getStations())->map(function ($station) {
                return Station::createFromPayload($station);
            });
        }

        return $this->stations;
    }

    /**
     * Get the stations. Temporal result.
     *
     * @return array
     */
    private function getStations()
    {
        $html = file_get_contents('http://girocleta.cat');

        $locations = preg_match_all(self::REGEX_LOCATION, $html, $matches) ? $matches[1] : [];

        preg_match_all(self::REGEX_STATION, $html, $matches);

        return array_map(function ($index) use ($matches, $locations) {

            [$latitude, $longitude] = explode(',', $locations[$index]);

            return [
                'id' => $matches['id'][$index],
                'name' => $matches['name'][$index],
                'parkings' => $matches['parkings'][$index],
                'bikes' => $matches['bikes'][$index],
                'latitude' => $latitude,
                'longitude' => $longitude
            ];
        }, array_keys($locations));
    }

    /**
     * Return stations as buttons in key - value format.
     *
     * @return mixed
     */
    public function asButtons()
    {
        return $this->all()->map->asButton()->toArray();
    }

    /**
     * Find the station by id.
     *
     * @param int $id
     *
     * @return Station|null
     */
    public function find($id)
    {
        return $this->all()->where('id', $id)->first();
    }

    /**
     * Get the nearest stations to the location.
     * 
     * @param float $latitude
     * @param float $longitude
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getNearStations(float $latitude, float $longitude, int $limit = 3)
    {
        return $this->all()->each->withDistanceTo($latitude, $longitude)
            ->sortBy('distance')
            ->take($limit);
    }


}