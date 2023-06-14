<?php

namespace App\Notifications;

use App\Events\PriceChangeDetected;
use App\Models\PriceChange;

class AddPriceChangeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PriceChangeDetected  $event
     * @return void
     */
    public function handle(PriceChangeDetected $event)
    {
        $change = PriceChange::create([
            "product->id" => $event->change["product_id"],
            "from" => $event->change["from"],
            "to" => $event->change["to"]
        ]);
    }
}
