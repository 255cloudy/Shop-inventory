<?php

namespace Database\Factories;

use App\Models\categories;
use App\Models\expense;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\expense>
 */
class ExpensesFactory extends Factory
{
    protected $model = expense::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            "name" => $this->faker->word,
            "amount" => $this->faker->numberBetween(100, 2000),
            "recurring" => $this->getRandom([true, false]),
            "category_id" => $this->getCategory()[0]->id
        ];
    }
    protected function getCategory(){
        return  categories::inRandomOrder()->limit(1)->get();
    }
    protected function getRandom($array){
        $index = array_rand($array, 1);
        return $array[$index];
    }
}
