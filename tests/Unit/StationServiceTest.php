<?php

namespace Tests\Unit;

use App\Services\StationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StationServiceTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function can_get_stations_from_website()
    {
        $stations = (new StationService())->all();

        $this->assertNotEmpty($stations);
    }
}