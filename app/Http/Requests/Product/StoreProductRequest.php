<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'image' => 'max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
        ];
    }
}
