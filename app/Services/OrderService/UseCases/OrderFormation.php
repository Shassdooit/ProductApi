<?php

namespace App\Services\OrderService\UseCases;

use App\Enums\OrderStatusEnum;
use App\Models\Cart;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderFormation
{

    /**
     * @throws Exception
     */
    function createOrderFromCart(Cart $cart)
    {
        DB::beginTransaction();

        try {
            $user = $cart->user;

            $order = Order::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'address' => $user->address,
                'phone' => $user->phone,
                'status' => OrderStatusEnum::UNPAID,
                'total' => $cart->products->sum(fn($product) => $product->pivot->quantity * $product->price),
            ]);

            $orderProducts = $cart->products->mapWithKeys(function ($product) {
                return [
                    $product->id => [
                        'product_id' => $product->id,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->price,
                    ]
                ];
            });

            $order->orderProducts()->createMany($orderProducts->toArray());

            $cart->delete();

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
