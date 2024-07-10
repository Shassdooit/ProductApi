<?php

namespace App\Services\CartService;

use App\DTO\Cart\StoreCartItemDTO;
use App\DTO\Cart\UpdateCartItemDTO;
use App\Models\Cart;

class CartService
{
    public function getAllItems(int $userId)
    {
        return Cart::where('user_id', $userId)->with('product')->get();
    }

    public function addItem(int $userId, StoreCartItemDTO $storeCartItemDTO) :void
    {
        Cart::updateOrCreate([
            'user_id' => $userId,
            'product_id' => $storeCartItemDTO->productId,
            'quantity' => $storeCartItemDTO->quantity,
        ]);
    }

    public function updateItem(int $userId, int $cartItemId, UpdateCartItemDTO $updateCartItemDTO) :void
    {
        $cartItem = Cart::where('user_id', $userId)->findOrFail($cartItemId);
        $cartItem->update(['quantity' => $updateCartItemDTO->quantity]);
    }

    public function removeItem(int $userId, int $cartItemId): void
    {
        $cartItem = Cart::where('user_id', $userId)->findOrFail($cartItemId);
        $cartItem->delete();
    }
}
