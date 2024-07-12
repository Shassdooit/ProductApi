<?php

namespace App\DTO\Cart;

readonly class StoreCartItemDTO
{
    public function __construct(
        public int $userId,
        public int $productId,
        public int $quantity,
    ) {
    }
}
