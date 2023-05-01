<?php

namespace App\Http\Controllers;

use App\View\ViewModels\PersonalOrderDetailViewModel;
use App\View\ViewModels\PersonalOrderListViewModel;

class PersonalController extends Controller
{
    public function orders(): PersonalOrderListViewModel
    {
        return (new PersonalOrderListViewModel())->view('personal.orders');
    }

    public function order(int $id): PersonalOrderDetailViewModel
    {
        return (new PersonalOrderDetailViewModel($id))->view('personal.orders-detail');
    }
}
