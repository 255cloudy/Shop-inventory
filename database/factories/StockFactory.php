<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "retail_price" => $this->faker->numberBetween(200, 500),
            "sales_price" => $this->faker->numberBetween(300, 800),
            "qty" => $this->faker->numberBetween(10, 100)
        ];
    }
}
