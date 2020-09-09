<?php

namespace App\Services;

use App\Girocleta\Station;

class StationService
{

    private $stations;

    const REGEX = "/addMarker\((?<latitude>\-?\d+(?:\.\d+)?),(?<longitude>\-?\d+(?:\.\d+)?).*>(?<id>\d+)-\s?(?<name>.*)<\/div><div>(?<address>.*)<\/div><div>Bicis lliures: (?<bikes>\d+)<\/div><div>Aparcaments lliures: (?<parkings>\d+)<\/div><\/div>'\);/";

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
        preg_match_all(self::REGEX, $this->query(), $matches);

        return array_map(function ($index) use ($matches) {

            return [
                'id' => $matches['id'][$index],
                'name' => $matches['name'][$index],
                'parkings' => $matches['parkings'][$index],
                'bikes' => $matches['bikes'][$index],
                'latitude' => $matches['latitude'][$index],
                'longitude' => $matches['longitude'][$index],
            ];
        }, array_keys($matches[0]));
    }

    private function query()
    {
        return file_get_contents('https://www.girocleta.cat/mapaestacions.aspx', false, stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));
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
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNearStations(float $latitude, float $longitude, int $limit = 3)
    {
        return $this->all()->each->withDistanceTo($latitude, $longitude)
            ->sortBy('distance')
            ->take($limit);
    }

    /**
     * @param string $text
     *
     * @return Station|null
     */
    public function findByText($text)
    {
        /** @var Station $station */
        $station = $this->all()->filter(function (Station $station) use ($text) {
            similar_text(strtolower($station->name), strtolower($text), $percentage);

            $station->percentage = $percentage;

            return $percentage >= 60;

        })->sortByDesc('percentage')->first();

        if ($station) {
            return $station->foundByText();
        }

        $alias = auth()->user()->aliases()->where('alias', 'like', "%{$text}%")->first();

        if ($alias && $station = $this->find($alias->station_id)) {
            return $station->foundByAlias();
        }

        if (! str_contains($text, 'girona')) {
            $text .= ' girona';
        }

        $addressLocation = (new GoogleMapsService())->getAddressLocation($text);

        if (! $addressLocation) {
            return null;
        }

        $station = $this->getNearStations($addressLocation->latitude, $addressLocation->longitude, 1)->first();

        return $station && $station->distance <= 4 ? $station->foundByAddress() : null;
    }

}
