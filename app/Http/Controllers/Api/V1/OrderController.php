<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Order\CreateOrderDTO;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Services\OrderService\UseCases\OrderFormation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @method validate(Request $request, string[] $array)
 */
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

        return response()->json(OrderResource::collection($orders));
    }

    public function getOrder($orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(new OrderResource($order->load('orderProducts.product')));
    }

    public function updateOrderStatus(Request $request, $orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);

        $validated = $request->validate([
            'status' => 'required|string|in:unpaid,paid,preparing,on_the_way,delivered,cancelled',
        ]);

        $order->status = OrderStatusEnum::from($validated['status']);
        $order->save();

        return response()->json(['message' => 'Order status updated successfully', 'order' => $order]);
    }
}
