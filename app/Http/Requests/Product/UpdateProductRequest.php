<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'max:255',
            'image' => 'max:255',
            'description' => 'max:255',
            'price' => 'numeric',
        ];
    }
}
