<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;


use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Product::factory(10)
            ->create();

        User::factory(100)
            ->has(Order::factory()->count(1)->has(OrderProduct::factory(1)))
            ->has(Cart::factory()->count(1))
            ->create();

    }


    //создать 10 заказов, у каждого из которых будет 2 заказ-продукта
    //
    //создать 100 юзеров, у каждго из которых будет по 5 заказов


}
