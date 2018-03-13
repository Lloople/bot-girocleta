<?php

namespace App\Services;

use App\Girocleta\Location;
use GuzzleHttp\Client;

class GoogleMapsService
{

    public function getAddressLocation(string $query)
    {
        $token = config('services.google_maps.token');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$query}&key={$token}";

        $client = new Client();
        $response = $client->post($url);

        $response = json_decode($response->getBody());

        if (! $response->results || ! isset($response->results[0]->geometry->location)) {
            return null;
        }

        $location = $response->results[0]->geometry->location;

        return new Location($location->lat, $location->lng);
    }
}