<?php

namespace App\Http\Controllers\Api\V1;


use App\DTO\Cart\StoreCartItemDTO;
use App\DTO\Cart\UpdateCartItemDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Services\CartService\UseCases\AddItem;
use App\Services\CartService\UseCases\GetAllItems;
use App\Services\CartService\UseCases\RemoveItem;
use App\Services\CartService\UseCases\UpdateItem;
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
        $validatedData = $request->validated();

        $dto = new StoreCartItemDto(
            $validatedData['user_id'],
            $validatedData['product_id'],
            $validatedData['quantity']
        );

        $this->addItem->execute($dto);

        return response()->json(['massage' => 'Item added successfully']);
    }

    public function update(UpdateCartItemRequest $request, int $userId, int $cartItemId): JsonResponse
    {
        $validatedData = $request->validated();

        $dto = new UpdateCartItemDTO(
            $userId,
            $cartItemId,
            $validatedData['quantity']
        );

        $this->updateItem->execute($dto);

        return response()->json(['message' => 'Item updated successfully']);
    }


    public function destroy($userId, $cartItemId): JsonResponse
    {
        $this->removeItem->execute($userId, $cartItemId);
        return response()->json(['message' => 'Item removed successfully']);
    }
}
