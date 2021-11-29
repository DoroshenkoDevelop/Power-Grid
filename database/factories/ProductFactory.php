<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'name'=> $this->faker->name,
            'price' => $this->faker->numberBetween(1,100),
            'account_id' => $this->faker->unique()->numberBetween(1,100)
        ];
    }
}
