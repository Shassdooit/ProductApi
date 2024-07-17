<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\UpdateCartItemDTO;
use App\Models\Cart;

class UpdateItem
{
    public function execute(UpdateCartItemDTO $updateCartItemDTO): void
    {
        $cartItem = Cart::where([
            'user_id' => $updateCartItemDTO->userId,
            'product_id' => $updateCartItemDTO->productId,
        ])->first();

        if ($cartItem) {
            $cartItem->quantity = $updateCartItemDTO->quantity;
            $cartItem->save();
        }
    }
}
