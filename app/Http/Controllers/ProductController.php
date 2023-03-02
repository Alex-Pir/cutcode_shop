<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load(['optionValues.option']);
        $viewedProducts = [];

        session()->put('also.' . $product->id, $product->id);

        $also = Product::query()
            ->whereIn('id', session('also'))
            ->whereNot('id', $product->id)
            ->get();

        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });


        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'viewed' => $viewedProducts,
            'also' => $also
        ]);
    }
}
