<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Decorations\Tab;
use Leeto\MoonShine\Decorations\Tabs;
use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\BelongsToMany;
use Leeto\MoonShine\Fields\Image;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Filters\BelongsToFilter;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
	public static string $model = Product::class;

	public static string $title = 'Products';

    public static array $with = [
        'brand',
        'categories',
        'properties',
        'optionValues'
    ];

	public function fields(): array
	{
		return [
		    Block::make('form-container', [
		        Tabs::make([
                    Tab::make('Basic', [
                        ID::make()->sortable(),
                        Text::make('Title'),
                        BelongsTo::make('Brand'),
                        Text::make('Price'),
                        Image::make('Thumbnail')
                            ->dir('images/products')
                            ->withPrefix('/storage/'),
                    ]),
                    Tab::make('Categories', [
                        BelongsToMany::make('Categories', resource: 'title')
                            ->hideOnIndex()
                    ]),
                    Tab::make('Properties', [
                        BelongsToMany::make('Properties', resource: 'title')
                            ->fields([
                                Text::make('Value')
                            ])
                        ->hideOnIndex()
                    ]),
                    Tab::make('Options', [
                        BelongsToMany::make('OptionValues', resource: 'title')
                            ->fields([
                                Text::make('Value')
                            ])
                        ->hideOnIndex()
                    ])
                ])
		    ])
        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make('Brand')
                ->searchable()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
