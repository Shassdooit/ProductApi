<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Order\CreateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\OrderService\UseCases\OrderFormation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function __construct(
        protected OrderFormation $orderFormation,
    ) {
    }

    public function createOrderFromCart(CreateOrderRequest $request): JsonResponse
    {
        $user = Auth::user();

        $dto = new CreateOrderDTO(
            $request->validated()['cart_id'],
            $user->id,
        );

        $cart = Cart::where('id', $dto->cartId)->where('user_id', $dto->userId)->firstOrFail();

        try {
            $order = $this->orderFormation->createOrderFromCart($cart);

            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUserOrders(): JsonResponse
    {
        $user = Auth::user();

        $orders = $user->orders()->with('orderProducts.product')->get();

        return response()->json(['orders' => $orders]);
    }

    public function getOrder(Order $order): JsonResponse
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['order' => $order->load('orderProducts.product')]);
    }

}
