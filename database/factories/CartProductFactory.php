<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cart_id' => Cart::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
