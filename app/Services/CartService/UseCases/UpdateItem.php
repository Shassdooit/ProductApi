<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\UpdateCartItemDTO;
use App\Models\Cart;

class UpdateItem
{
    public function execute(UpdateCartItemDTO $updateCartItemDTO): void
    {
        $cartItem = Cart::where('user_id', $updateCartItemDTO->userId)->first();

        if ($cartItem) {
            $cartItem->products()->updateExistingPivot(
                $updateCartItemDTO->productId,
                ['quantity' => $updateCartItemDTO->quantity]
            );
        }
    }
}
