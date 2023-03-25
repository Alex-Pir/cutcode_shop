<?php

namespace Domain\Order\Providers;

use Domain\Cart\CartManager;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->register(
            PaymentServiceProvider::class
        );
    }
}
