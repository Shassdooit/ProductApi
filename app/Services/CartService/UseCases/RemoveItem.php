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
        $cart = Cart::where('user_id', $userId)
            ->first()
            ?? throw new CartNotFoundException();

        $cart->products()->where('product_id', $productId)
            ->exists() ?? throw new ProductNotFoundException();
        $cart->products()->detach($productId);
    }
}
