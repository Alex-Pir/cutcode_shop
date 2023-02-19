<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Cache\CategoryCacheEnum;
use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function saved(Category $category): void
    {
        $this->clearCache();
    }

    public function deleted(Category $category): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        foreach (CategoryCacheEnum::cases() as $case) {
            Cache::forget($case->key());
        }
    }
}
