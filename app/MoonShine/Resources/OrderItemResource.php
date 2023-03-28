<?php

namespace App\MoonShine\Resources;

use Domain\Order\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\Number;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class OrderItemResource extends Resource
{
	public static string $model = OrderItem::class;

	public static string $title = 'OrderItem';

	public function fields(): array
	{
		return [
		    Block::make('form-container', [
		        ID::make()->sortable(),
                Text::make('Price'),
                Number::make('Quantity'),
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
