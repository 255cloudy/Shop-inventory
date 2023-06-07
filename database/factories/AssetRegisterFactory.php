<?php

namespace Database\Factories;

use App\Models\asset_register;
use Illuminate\Database\Eloquent\Factories\Factory;



class AssetRegisterFactory extends Factory
{
    protected $model = asset_register::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word,
            "condition" => Helper::getRandom(["good", "out of order"]),
            "qty" => $this->faker->numberBetween(0, 10)
        ];
    }

}
