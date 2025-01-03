<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Api\ApiData;
use App\Http\Responses\Api\CartResponse;
use Domain\Cart\CartManager;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class CartController
{
    public function index(CartManager $cart, CartResponse $response): CartResponse
    {
        return $response->toCollection(
            $cart->items()->map(fn (CartItem $item) => new ApiData(
                $response->type(),
                $item->getKey(),
                $item->toArray()
            ))
        );
    }

    public function add(int $id, CartManager $cart): Response
    {
        $product = Product::query()->findOrFail($id);

        $cart->add($product);

        return response()->noContent(
            Response::HTTP_CREATED
        );
    }
}
