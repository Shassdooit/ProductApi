<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\StoreCartItemDTO;
use App\Models\Cart;

class AddItem
{
    public function execute(StoreCartItemDTO $storeCartItemDTO): void
    {
        $cart = Cart::firstOrCreate(['user_id' => $storeCartItemDTO->userId]);

        $existingProduct = $cart->products()
            ->where('product_id', $storeCartItemDTO->productId)
            ->first();

        if ($existingProduct) {
            $existingProduct->pivot->increment('quantity', $storeCartItemDTO->quantity);
        }
        $cart->products()
            ->attach($storeCartItemDTO->productId, ['quantity' => $storeCartItemDTO->quantity]);
    }
}
