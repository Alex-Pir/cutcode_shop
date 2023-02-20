<?php

namespace Domain\Catalog\Providers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\Observers\CategoryObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Category::observe(CategoryObserver::class);
        Brand::observe(BrandObserver::class);
    }
}
