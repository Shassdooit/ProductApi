<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\StoreCartItemDTO;
use App\Models\Cart;

class AddItem
{
    public function execute(StoreCartItemDTO $storeCartItemDTO): void
    {
        $cart = Cart::firstOrCreate(['user_id' => $storeCartItemDTO->userId]);
        $cart->products()->updateOrCreate(
            ['id' => $storeCartItemDTO->productId],
            ['quantity' => $storeCartItemDTO->quantity]
        );
    }
}
