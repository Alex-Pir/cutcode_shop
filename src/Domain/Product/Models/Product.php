<?php

namespace Domain\Product\Models;

use App\Jobs\ProductJsonProperties;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Collections\OptionValueCollection;
use Domain\Product\Collections\PropertyCollection;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @property int $id
 * @property string $slug
 * @property int $brand_id
 * @property int $price
 * @property string $thumbnail
 * @property bool $on_home_page
 * @property int $sorting
 * @property string $text
 * @property array $json_properties
 * @property Brand $brand
 * @property CategoryCollection|Category[] $categories
 * @property PropertyCollection|Property[] $properties
 * @property OptionValueCollection|OptionValue[] optionValues
 *
 * @method static Product|ProductQueryBuilder query()
 */
class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
        'json_properties',
        'quantity'
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function (Product $product) {
            ProductJsonProperties::dispatch($product)
                ->delay(now()->addSeconds(10));
        });
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }
}
