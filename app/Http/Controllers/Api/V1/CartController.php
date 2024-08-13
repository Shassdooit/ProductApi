<?php

namespace App\Http\Controllers\Api\V1;


use App\DTO\Cart\StoreCartItemDTO;
use App\DTO\Cart\UpdateCartItemDTO;
use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
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
        try {
            $items = $this->getAllItems->execute($userId);
            return response()->json(new CartResource($items));
        } catch (CartNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $dto = new StoreCartItemDTO(
            $validatedData['user_id'],
            $validatedData['product_id'],
            $validatedData['quantity']
        );

        $this->addItem->execute($dto);

        return response()->json(['message' => 'Item added successfully']);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateCartItemRequest $request, int $userId, int $cartItemId): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $dto = new UpdateCartItemDTO(
                $userId,
                $cartItemId,
                $validatedData['quantity']
            );

            $this->updateItem->execute($dto);

            return response()->json(['message' => 'Item updated successfully']);
        } catch (ProductNotFoundException|CartNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy($userId, $productId): JsonResponse
    {
        try {
            $this->removeItem->execute($userId, $productId);
            return response()->json(['message' => 'Item removed successfully'], 200);
        } catch (CartNotFoundException|ProductNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
