<?php

namespace Domain\Catalog\Collections;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Collection as MemoryCollection;

class CategoryCollection extends Collection
{
    public function optionKeyValues(): MemoryCollection
    {
        $result = collect();

        foreach ($this->items as $item) {
            $result = $result->merge($item->optionValues->keyValues());
        }

        return $result;
    }
}
