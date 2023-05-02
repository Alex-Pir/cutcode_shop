<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class OrderRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/order', [OrderController::class, 'index'])
                ->name('order');
            Route::post('/order', [OrderController::class, 'handle'])
                ->name('order.handle');
            Route::get('/personal/orders', [PersonalController::class, 'orders'])
                ->middleware(['auth'])
                ->name('personal.orders');
            Route::get('/personal/orders/{id}', [PersonalController::class, 'order'])
                ->middleware(['auth'])
                ->name('personal.order');
        });
    }
}
