<?php

namespace App\Http\Responses\Api\Transformers;

use App\Http\Responses\Api\ApiData;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Support\Arrayable;

final readonly class CatalogTransformer implements Arrayable
{
    public function __construct(
        private Product $product
    ) {
    }

    public function toArray(): array
    {
        return (new ApiData(
            'catalog',
            $this->product->getKey(),
            [
                'id' => $this->product->getKey(),
            ]
        ))->toArray();
    }
}
