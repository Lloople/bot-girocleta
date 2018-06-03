<?php

namespace Tests\Unit;

use App\Girocleta\Station;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Tests\TestCase;

class StationTest extends TestCase
{

    /** @test */
    public function can_be_created_from_service_payload()
    {
        $station = $this->getDummyStation();

        $this->assertEquals(1, $station->id);
        $this->assertEquals('Dummy Station', $station->name);
        $this->assertEquals(4, $station->parkings);
        $this->assertEquals(5, $station->bikes);
    }

    /** @test */
    public function can_get_station_as_botman_button()
    {
        $station = $this->getDummyStation();

        $button = $station->asButton();

        $this->assertInstanceOf(Button::class, $button);

        $this->assertEquals('Dummy Station', $button->toArray()['name']);

        $this->assertEquals(1, $button->toArray()['value']);
    }


    /** @test */
    public function can_get_station_with_distance_to_location_setted()
    {
        $station = $this->getDummyStation([
            'latitude' => 0,
            'longitude' => 0,
        ]);

        $station->withDistanceTo(0, 0);

        $this->assertEquals(0, $station->distance);

        $station->withDistanceTo(0, 1);

        $this->assertEquals(111.19, $station->distance);

    }

    private function getDummyStation(array $overrides = [])
    {
        $properties = [
            'id' => 1,
            'name' => 'Dummy Station',
            'latitude' => 111111,
            'longitude' => 222222,
            'parkings' => 4,
            'bikes' => 5
        ];

        $properties = array_merge($properties, $overrides);

        return Station::createFromPayload($properties);
    }
}