<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class UtcTimezoneProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void use Carbon\Carbon; use Carbon\Carbon;
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive("convertEAT", function($datetimestring){
            return '<?php
             $date = new Carbon($datetimestring);
            echo $date->tz("UTC")->toDayDateTimeString() ?>';
        });
    }
}
