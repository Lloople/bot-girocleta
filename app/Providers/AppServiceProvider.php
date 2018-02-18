<?php

namespace App\Providers;

use App\Drivers\TelegramDriver;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        DriverManager::loadDriver(TelegramDriver::class);
    }
}
