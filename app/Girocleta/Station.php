<?php

namespace App\Girocleta;

class Station
{

    public function all()
    {
        return collect(json_decode(file_get_contents(resource_path('girocleta/stations.json'))))->keyBy('id');
    }
}