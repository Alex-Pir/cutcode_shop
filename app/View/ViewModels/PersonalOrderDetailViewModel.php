<?php

namespace App\View\ViewModels;

use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Spatie\ViewModels\ViewModel;

class PersonalOrderDetailViewModel extends ViewModel
{
    public function __construct(protected int $orderId)
    {
    }

    public function order(): Order|Builder|null
    {
        return Order::query()
            ->where('id', $this->orderId)
            ->where('user_id', auth()->id())
            ->with([
                'orderItems',
                'orderItems.product',
                'orderItems.optionValues.option',
            ])
            ->firstOrFail();
    }
}
