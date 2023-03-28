<?php

namespace App\MoonShine\Resources;

use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\HasMany;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class OrderResource extends Resource
{
	public static string $model = Order::class;

	public static string $title = 'Order';

    public static array $with = [
        'orderItems'
    ];

	public function fields(): array
	{
		return [
		    Block::make('form-container', [
		        ID::make()->sortable(),
                HasMany::make('Order item', 'orderItems')
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
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
