<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::all());
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $createdProduct = Product::create($request->validated());

        return new ProductResource($createdProduct);
    }

    public function show(string $id): ProductResource
    {
        return new ProductResource(Product::findOrFail($id));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
