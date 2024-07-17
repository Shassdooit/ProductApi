<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\StoreCartItemDTO;
use App\Models\Cart;

class AddItem
{
    public function execute(StoreCartItemDTO $storeCartItemDTO): void
    {
        Cart::updateOrCreate(
            [
                'user_id' => $storeCartItemDTO->userId,
                'product_id' => $storeCartItemDTO->productId
            ],
            [
                'quantity' => $storeCartItemDTO->quantity,
            ]
        );
    }
}
