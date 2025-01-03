<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    protected $signature = 'redis:subscribe';

    protected $description = 'Subscribe to a Redis channel';

    public function handle(): void
    {
        $this->info('start listening');
        Redis::subscribe(['product_change'], function ($message) {
            print_r($message . "\n");
        });
    }
}
