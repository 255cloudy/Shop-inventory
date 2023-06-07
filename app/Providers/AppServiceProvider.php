<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::if("active", function ($current, $expected){
            $pattern = "/".$expected."/";
            if(preg_match($pattern, $current) == 1) {
                return true;
            }
            return false;
        });
    }
}
