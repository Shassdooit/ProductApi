<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\UpdateCartItemDTO;
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
            ->firstOrFail();

        $productInCart = $cart->products()
            ->where('product_id', $updateCartItemDTO->productId)
            ->firstOrFail();

        $newQuantity = $productInCart->pivot->quantity + $updateCartItemDTO->quantity;

        if ($newQuantity > 0) {
            $cart->products()->updateExistingPivot(
                $updateCartItemDTO->productId,
                ['quantity' => $newQuantity]
            );
        } else {
            $cart->products()->detach($updateCartItemDTO->productId);
        }
    }
}

