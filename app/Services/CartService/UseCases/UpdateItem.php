<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\UpdateCartItemDTO;
use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Cart;
use Exception;

class UpdateItem
{
    /**
     * @throws Exception
     */
    public function execute(UpdateCartItemDTO $updateCartItemDTO): void
    {
        $cart = Cart::where('user_id', $updateCartItemDTO->userId)
            ->first() ?? throw new CartNotFoundException();

        $cart->products()->where('product_id', $updateCartItemDTO->productId)
                ->exists() ?? throw new ProductNotFoundException();

        $cart->products()->updateExistingPivot(
            $updateCartItemDTO->productId,
            ['quantity' => $updateCartItemDTO->quantity]
        );
    }

}
