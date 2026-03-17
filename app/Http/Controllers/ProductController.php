<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(ProductService $service)
    {
        $products = $service->list(request()->all());

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $log = $product->update_log ?? [];

        $log[] = [
            'action' => 'updated',
            'before' => $product->only(array_keys($data)),
            'after' => $data,
            'date' => now()
        ];

        $product->update([
            ...$data,
            'update_log' => $log
        ]);

        return new ProductResource($product);
    }

    public function destroy(Request $request, Product $product)
    {
        if($product->rating_rate > 4.5){
            return response()->json([
                'error' => 'Product cannot be removed'
            ],422);
        }

        $log = $product->update_log ?? [];

        $log[] = [
            'action' => 'deleted',
            'reason' => $request->input('reason'),
            'date' => now()
        ];

        $product->update([
            'update_log' => $log
        ]);

        $product->delete();

        return response()->json([
            'deleted' => true
        ]);
    }
}