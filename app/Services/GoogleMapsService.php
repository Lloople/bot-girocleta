<?php

namespace App\Services;

use App\Girocleta\Location;

class GoogleMapsService
{

    public function getMarker(Location $location)
    {
        return "https://www.google.com/maps/search/?api=1&query={$location->getLatitude()},{$location->getLongitude()}";
    }

    public function getAddressLocation(string $query)
    {
        // TO-DO Query the google maps API to get lat and lon of the address
        // Also, we must restrict the searching area to Girona
    }
}