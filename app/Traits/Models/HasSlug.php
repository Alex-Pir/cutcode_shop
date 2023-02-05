<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $newSlug = $slug = $model->slug
                ?? str($model->{self::slugFrom()})
                    ->append(time())
                    ->slug()->value();

            /** @var Collection $existsSlugs */
            $existsSlugs = $model->query()->existSlugs($slug)->pluck('slug');
            $slugIndex = 1;

            while($existsSlugs->contains($newSlug)) {
                $newSlug = "{$slug}_" . $slugIndex++;
            }

            $model->slug = $newSlug;
        });
    }

    public function scopeExistSlugs(Builder $query, string $fieldValue): Builder
    {
        return $query->where('slug', $fieldValue)
            ->orWhere('slug', 'LIKE', "$fieldValue%");
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
