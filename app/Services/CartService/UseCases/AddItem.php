<?php

namespace App\Services\CartService\UseCases;

use App\DTO\Cart\StoreCartItemDTO;
use App\Models\CartProduct;


class AddItem
{
    public function execute(StoreCartItemDTO $storeCartItemDTO): void
    {
        CartProduct::updateOrCreate(
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
