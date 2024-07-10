<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'order_id' => Order::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
