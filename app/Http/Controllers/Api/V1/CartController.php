<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Cart\StoreCartItemDTO;
use App\DTO\Cart\UpdateCartItemDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Services\CartService\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $cartItems = $this->cartService->getAllItems($request->user()->id);
        return response()->json($cartItems);
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $validatedRequest = $request->validated();
        $storeCartItemDto = new StoreCartItemDto(
            $validatedRequest['product_id'],
            $validatedRequest['quantity'],
        );

        $this->cartService->addItem($request->user()->id, $storeCartItemDto);

        return response()->json(status: 201);
    }

    public function update(UpdateCartItemRequest $request, $id): JsonResponse
    {
        $validatedRequest = $request->validated();
        $updateCartItemDto = new UpdateCartItemDto(
            $validatedRequest['quantity'],
        );

        $this->cartService->updateItem($request->user()->id, $id, $updateCartItemDto);

        return response()->json($updateCartItemDto);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $this->cartService->removeItem($request->user()->id, $id);

        return response()->json(null, 204);
    }
}
