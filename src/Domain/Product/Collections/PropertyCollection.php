<?php

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use \Illuminate\Support\Collection;

class PropertyCollection extends DatabaseCollection
{
    public function keyValues(): PropertyCollection|Collection
    {
        return $this->mapWithKeys(
            fn($property) => [$property->title => $property->pivot->value]
        );
    }
}
