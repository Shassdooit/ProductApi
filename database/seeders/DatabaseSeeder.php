<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;


use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $products = Product::factory(10)->create();


        User::factory(10)
            ->has(
                Order::factory()->count(1)
                    ->has(
                        OrderProduct::factory(1)
                    )
            )
            ->has(
                Cart::factory()->count(1)
                    ->afterCreating(function (Cart $cart) use ($products) {
                        $product = $products->shift();
                        if ($product) {
                            $cart->products()->attach($product->id);
                        }
                    })
            )
            ->create();
    }
}
