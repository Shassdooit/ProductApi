<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Services\CartService\UseCases\AddItem;
use App\Services\CartService\UseCases\GetAllItems;
use App\Services\CartService\UseCases\RemoveItem;
use App\Services\CartService\UseCases\UpdateItem;
use Exception;
use Illuminate\Http\JsonResponse;


class CartController extends Controller
{
    public function __construct(
        protected GetAllItems $getAllItems,
        protected AddItem $addItem,
        protected UpdateItem $updateItem,
        protected RemoveItem $removeItem,
    ) {
    }

    public function index($userId): JsonResponse
    {
        $items = $this->getAllItems->execute($userId);
        return response()->json($items);
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $this->addItem->execute($request->validated());
        return response()->json(['message' => 'Item added successfully']);
    }

    public function update(UpdateCartItemRequest $request, $userId, $cartItemId): JsonResponse
    {
        $this->updateItem->execute($request->validated());
        return response()->json(['message' => 'Item updated successfully']);
    }

    /**
     * @throws Exception
     */
    public function destroy($userId, $cartItemId): JsonResponse
    {
        try {
            $this->removeItem->execute($userId, $cartItemId);
            return response()->json(['message' => 'Item removed successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
