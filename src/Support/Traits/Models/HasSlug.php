<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if ($this->{$this->slugColumn()}) {
            return;
        }

        $this->{$this->slugColumn()} = $this->slugUnique(
            str($this->{$this->slugFrom()})
                ->slug()
                ->value()
        );
    }

    protected function slugUnique(string $slug): string
    {
        $slugIndex = 1;
        $newSlug = $slug;

        /** @var Collection $existsSlugs */
        $existsSlugs = $this->newQuery()->existSlugs($slug)->pluck('slug');

        while($existsSlugs->contains($newSlug)) {
            $newSlug = "{$slug}_" . $slugIndex++;
        }

        return $newSlug;
    }

    public function scopeExistSlugs(Builder $query, string $fieldValue): Builder
    {
        return $query->where('slug', $fieldValue)
            ->orWhere('slug', 'LIKE', "$fieldValue%");
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    protected function slugFrom(): string
    {
        return 'title';
    }
}
