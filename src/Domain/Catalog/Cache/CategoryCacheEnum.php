<?php

namespace Domain\Catalog\Cache;

enum CategoryCacheEnum: string
{
    case CategoryHomePage = 'category_home_page';

    public function key(): string
    {
        return $this->value;
    }
}
