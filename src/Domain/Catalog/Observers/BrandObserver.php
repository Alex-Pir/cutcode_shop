<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Cache\BrandCacheEnum;
use Domain\Catalog\Cache\CategoryCacheEnum;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function saved(Brand $brand): void
    {
        $this->clearCache();
    }

    public function deleted(Brand $brand): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        foreach (BrandCacheEnum::cases() as $case) {
            Cache::forget($case->key());
        }
    }
}
