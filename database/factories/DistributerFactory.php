<?php

namespace Database\Factories;

use App\Models\categories;
use App\Models\distributer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\distributer>
 */
class DistributerFactory extends Factory
{
    protected  $model = distributer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name"=> $this->faker->name
        ];
    }
}
