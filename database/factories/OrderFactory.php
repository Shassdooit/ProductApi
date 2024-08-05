<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(OrderStatusEnum::cases()),
            'total' => $this->faker->randomFloat(2, 800, 10000),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
