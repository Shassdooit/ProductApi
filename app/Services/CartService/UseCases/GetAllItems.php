<?php

namespace App\Services\CartService\UseCases;


use App\Models\CartProduct;

class GetAllItems
{
    public function execute(int $userId)
    {
        return CartProduct::where('user_id', $userId)->with('product')->get();
    }
}
