<?php

namespace App\DTO\Order;

class CreateOrderDTO
{
    public function __construct(
        public int $cartId,
        public int $userId,
    ) {
    }
}
