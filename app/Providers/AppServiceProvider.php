<?php

namespace App\Providers;

use App\Guards\JWTGuard;
use App\Http\Kernel;
use Carbon\CarbonInterval;
use Domain\Auth\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug(
                            'query longer than 1s:' . $query->sql, $query->sql
                        );
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                fn() => logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan:' . request()->url())
            );
        }

        $this->app->instance(JWT::class, new JWT(
            config('auth.jwt_secret')
        ));

        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            return new JWTGuard(
                $app[JWT::class],
                Auth::createUserProvider($config['provider'])
            );
        });
    }
}

