<?php

namespace App\Girocleta;

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

}