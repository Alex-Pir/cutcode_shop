<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Cache\CategoryCacheEnum;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever(CategoryCacheEnum::CategoryHomePage->key(), function () {
            return Category::query()
                ->homePage()
                ->get();
        });
    }
}
