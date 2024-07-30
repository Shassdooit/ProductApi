<?php

namespace App\Services\CartService\UseCases;

use App\Exceptions\CartNotFoundException;
use App\Models\Cart;

class GetAllItems
{
    /**
     * @throws CartNotFoundException
     */
    public function execute(int $userId)
    {
        $cart = Cart::where('user_id', $userId)->with('products')->first();

        if (!$cart) {
            throw new CartNotFoundException();
        }
        return $cart;
    }
}
