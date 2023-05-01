<?php

namespace App\View\ViewModels;

use Domain\Order\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class PersonalOrderListViewModel extends ViewModel
{
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->where('user_id', auth()->id())
            ->with(['orderItems', 'orderItems.product'])
            ->has('orderItems')
            ->paginate(10);
    }
}
