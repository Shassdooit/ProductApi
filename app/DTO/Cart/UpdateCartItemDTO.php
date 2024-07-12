<?php

namespace App\DTO\Cart;

readonly class UpdateCartItemDTO
{

    public function __construct(
        public int $userId,
        public int $cartItemId,
        public int $quantity,
    ) {
    }
}
