<?php

namespace Database\Factories;

use App\Models\sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sale>
 */
class SaleFactory extends Factory
{
    protected $model = sale::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "sale_price" => $this->faker->numberBetween(250, 1000),
        ];
    }
}
