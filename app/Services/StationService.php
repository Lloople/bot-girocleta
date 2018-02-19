<?php

namespace App\Services;

use App\Girocleta\Station;

class StationService
{

    private $stations;

    /**
     * Load all the station just one time per instance.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        if (! $this->stations) {
            $this->stations = $this->getStations()->map(function ($stationJson) {
                return Station::createFromPayload($stationJson);
            });
        }

        return $this->stations;
    }

    /**
     * Get tehe stations. Temporal result.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getStations()
    {
        return collect(
            json_decode(
                file_get_contents(
                    resource_path('girocleta/stations.json')
                )
            )
        );

        /**
         * addMarker\(\d+,(\-?\d+(?:\.\d+)?,\s*\-?\d+(?:\.\d+)?),\d+,\d+\);
         * html\[\d+\]=\'<div.*>(?P<id>[0-9]+)- (?<name>.*)<\/div><div>.*<\/div><div>Bicis lliures: (?<bikes>\d+).*Aparcaments lliures: (?<parkings>\d+).*\';
         */
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