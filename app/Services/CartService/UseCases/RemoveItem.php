<?php

namespace App\Services\CartService\UseCases;

use App\Models\Cart;
use Exception;

use Illuminate\Support\Facades\DB;

class RemoveItem
{

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $cartItemId): void
    {
        $cartItem = DB::table('carts')
            ->where('user_id', $userId)
            ->where('id', $cartItemId)
            ->first();
        if ($cartItem) {
            $cartItem->delete();
        } else {
            throw new Exception('Item not found', 404);
        }
    }
}
