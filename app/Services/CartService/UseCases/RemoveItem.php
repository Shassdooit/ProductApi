<?php

namespace App\Services\CartService\UseCases;

use App\Models\Cart;
use Exception;


class RemoveItem
{

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $productId): void
    {
        $cart = Cart::where('user_id', $userId)->first();


        if ($cart) {
            if ($cart->products()->where('product_id', $productId)->exists()) {
                $cart->products()->detach($productId);
            } else {
                throw new Exception('Product not found in cart', 404);
            }
        } else {
            throw new Exception('Cart not found', 404);
        }
    }
}
