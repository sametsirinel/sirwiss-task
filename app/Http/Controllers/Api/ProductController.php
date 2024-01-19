<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Notifications\ProductCreatedMailNotify;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with("user")
            ->when($request->product, function ($q) use ($request) {
                $q->where("name", "like", "%{$request->product}%");
            })
            ->when($request->user, function ($q) use ($request) {
                $q->whereHas('user', function ($q) use ($request) {
                    $q->where("name", "like", "%{$request->user}%");
                });
            })
            ->whereNull("product_id")
            ->get();

        return $this->success([
            "products" => ProductResource::collection($products)
        ]);
    }

    public function store(Product $product, Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|min:5|max:50",
            "price" => "required|numeric",
            "status" => "required|numeric",
            "type" => "required|numeric",
        ]);

        /** @var User $user */
        $user = auth()->user();

        $validated["user_id"] = $user->id;

        $product = $product->create($validated);

        $user->notify(new ProductCreatedMailNotify());


        return $this->success([
            "products" => new ProductResource($product)
        ]);
    }

    public function show(Product $product)
    {
        return $this->success([
            "products" => new ProductResource($product)
        ]);
    }

    public function update(Product $product, Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|min:5|max:50",
            "price" => "required|numeric",
            "status" => "required|numeric",
            "type" => "required|numeric",
        ]);

        /** @var User $user */
        $user = auth()->user();

        $validated["user_id"] = $user->id;

        $product = $product->updateAndCreateVersion($validated);

        return $this->success([
            "products" => new ProductResource($product)
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success([]);
    }
}
