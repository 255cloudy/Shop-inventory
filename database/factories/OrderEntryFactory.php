<?php

namespace Database\Factories;

use App\Models\order_entry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\order_entry>
 */
class OrderEntryFactory extends Factory
{
    protected  $model = order_entry::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "qty" => $this->faker->numberBetween(10, 100),
            "retail_price" => $this->faker->numberBetween(200, 1000),
//            do a sequence for received
        ];
    }
}
