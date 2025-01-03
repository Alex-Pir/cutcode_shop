<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Api\Transformers\CatalogTransformer;
use App\View\ViewModels\CatalogViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogController
{
    public function index(CatalogViewModel $viewModel): LengthAwarePaginator
    {
        $products = $viewModel->products();
        $products->getCollection()->transform(fn (Product $product) => new CatalogTransformer($product));

        return $products;
    }
}
