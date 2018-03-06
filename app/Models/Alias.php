<?php

namespace App\Models;

use App\Services\StationService;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $table = 'aliases';

    public function getInfo()
    {
        return "{$this->alias} = {$this->getStationName()}";
    }

    public function getStationName()
    {
        return app(StationService::class)->find($this->station_id)->name;
    }

    public function asButton()
    {
        return Button::create($this->getInfo())->value($this->id);
    }

}
