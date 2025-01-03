<?php

namespace App\Http\Responses\Api;

use Symfony\Component\HttpFoundation\Response;

class CartResponse extends ApiResponse
{
    public function type(): string
    {
        return 'cart';
    }

    public function links(): array
    {
        return [
            'self' => route('api.cart.index'),
        ];
    }
}
