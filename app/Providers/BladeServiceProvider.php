<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
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
        Blade::directive('pricetojson', function ($prices) {
            $objects = [];
            foreach ($prices as $object ){
                $clone = [
                    "id"=> $object->id,
                    "product_id" => $object->product_id,
                    "sale_price" => $object->sale_price
                ];
                array_push($objects, $clone);
            }
            return json_encode($objects);
        });
        Blade::directive('stocktojson', function ($products) {
            $objects = [];
            foreach ($products as $object ){
                $clone = [
                    "id"=> $object->id,
                    "name" => $object->name
                ];
                array_push($objects, $clone);
            }
            return json_encode($objects);
        });
    }
}
