<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load(['categories.optionValues.option']);
        $viewedProducts = [];

        session()->put('also.' . $product->id, $product->id);

        $also = Product::query()
            ->whereIn('id', session('also'))
            ->whereNot('id', $product->id)
            ->get();

        return view('product.show', [
            'product' => $product,
            'options' => $product->categories->optionKeyValues(),
            'viewed' => $viewedProducts,
            'also' => $also
        ]);
    }
}
