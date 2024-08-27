<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $name
 * @property mixed $address
 * @property mixed $phone
 * @property mixed $status
 * @property mixed $total
 * @property mixed $created_at
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'status' => $this->status,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'order_products' => OrderProductResource::collection($this->whenLoaded('orderProducts')),
        ];
    }
}
