<?php

namespace App\DTO\Cart;

readonly class UpdateCartItemDTO
{

    public function __construct(
        public int $quantity,
    ) {
    }
}
