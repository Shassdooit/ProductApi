<?php

namespace App\Services\CartService\UseCases;

use App\Exceptions\CartNotFoundException;
use App\Models\Cart;

class GetAllItems
{
    /**
     * @throws CartNotFoundException
     */
    public function execute(int $userId)
    {
        return Cart::where('user_id', $userId)
            ->with('products')
            ->first()
            ?? throw new CartNotFoundException();
    }
}
