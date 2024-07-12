<?php

namespace App\Services\CartService\UseCases;

use App\Models\Cart;

class GetAllItems
{
    public function execute(int $userId)
    {
        return Cart::where('user_id', $userId)->with('product')->get();
    }
}
