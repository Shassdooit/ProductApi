<?php

namespace App\Services\CartService\UseCases;

use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
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


        if ($cart !== null) {
            if ($cart->products()->where('product_id', $productId)->exists()) {
                $cart->products()->detach($productId);
            } else {
                throw new ProductNotFoundException();
            }
        } else {
            throw new CartNotFoundException();
        }
    }
}
