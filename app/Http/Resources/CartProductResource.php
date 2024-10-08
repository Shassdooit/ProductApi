<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $pivot
 * @property mixed $price
 * @property mixed $description
 * @property mixed $image
 * @property mixed $title
 * @property mixed $id
 */
class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->pivot->quantity,
        ];
    }
}
