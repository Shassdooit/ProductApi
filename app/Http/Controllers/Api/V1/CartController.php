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
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function __construct(
        protected GetAllItems $getAllItems,
        protected AddItem $addItem,
        protected UpdateItem $updateItem,
        protected RemoveItem $removeItem,
    ) {
    }

    public function index(): JsonResponse
    {
        $userId = Auth::id();

        try {
            $items = $this->getAllItems->execute($userId);
            return response()->json(new CartResource($items));
        } catch (CartNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $user = Auth::user();

        $validatedData = $request->validated();

        $dto = new StoreCartItemDTO(
            $user->id,
            $validatedData['product_id'],
            $validatedData['quantity']
        );

        $this->addItem->execute($dto);

        return response()->json(['message' => 'Item added successfully']);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateCartItemRequest $request, int $productId): JsonResponse
    {
        $user = Auth::user();

        try {
            $validatedData = $request->validated();

            $dto = new UpdateCartItemDTO(
                $user->id,
                $productId,
                $validatedData['quantity']
            );

            $this->updateItem->execute($dto);

            return response()->json(['message' => 'Item updated successfully']);
        } catch (ProductNotFoundException|CartNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function destroy(int $productId): JsonResponse
    {
        $user = Auth::user();

        try {
            $this->removeItem->execute($user->id, $productId);
            return response()->json(['message' => 'Item removed successfully'], 200);
        } catch (CartNotFoundException|ProductNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}

