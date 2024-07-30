<?php

namespace App\Http\Resources;


use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    public function toArray(Cart|Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product' => CartProductResource::collection($this->products),

        ];
    }
}
