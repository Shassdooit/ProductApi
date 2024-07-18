<?php

namespace App\Services\CartService\UseCases;

use App\Models\Cart;
use Exception;


class RemoveItem
{

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $cartItemId): void
    {
        $cartItem = Cart::where('user_id', $userId)->first();
        if ($cartItem) {
            $cartItem->products()->detach($cartItemId);
        } else {
            throw new Exception('Item not found', 404);
        }
    }
}
