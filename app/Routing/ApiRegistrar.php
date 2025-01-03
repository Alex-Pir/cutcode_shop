<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Api\AuthenticateController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Middleware\ApiMiddleware;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class ApiRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('api')->prefix('api')->as('api.')->middleware(ApiMiddleware::class)->group(function () use ($registrar) {
            Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])->name('authenticate');
            Route::delete('/authenticate', [AuthenticateController::class, 'logout'])->name('logout')->middleware('auth:jwt');
            Route::put('/authenticate', [AuthenticateController::class, 'refresh'])->name('refresh_token');


            Route::controller(CartController::class)->as('cart.')->middleware(ApiMiddleware::class)->group(function () {
                Route::get('/cart', 'index')->name('index');
                Route::post('/cart/{id}', 'add')->name('add');
            });

            Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index')->middleware('auth:jwt');
        });
    }
}
