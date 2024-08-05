<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->text(5),
            'price' => $this->faker->numberBetween(500, 1200),
        ];
    }
}
