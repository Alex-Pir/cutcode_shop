<?php

namespace Domain\Catalog\Facades;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;
use Domain\Catalog\Sorters\Sorter as CatalogSorter;

/**
 * @method static Builder run(Builder $query)
 * @see CatalogSorter
 */
class Sorter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CatalogSorter::class;
    }
}
