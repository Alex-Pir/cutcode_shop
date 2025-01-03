<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\StorageIdentities\TokenIdentityStorage;
use Illuminate\Http\Request;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        auth()->shouldUse('jwt');

        app()->bind(CartIdentityStorageContract::class, TokenIdentityStorage::class);

        return $next($request);
    }
}
