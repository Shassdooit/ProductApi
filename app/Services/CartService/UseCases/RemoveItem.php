<?php

namespace App\Services\CartService\UseCases;


use App\Models\CartProduct;
use Exception;


class RemoveItem
{

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $cartItemId): void
    {
        $cartItem = CartProduct::where('user_id', $userId)
            ->where('product_id', $cartItemId)
            ->first();
        if ($cartItem) {
            $cartItem->delete();
        } else {
            throw new Exception('Item not found', 404);
        }
    }
}
