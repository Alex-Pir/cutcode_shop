<?php

namespace Domain\Cart\StorageIdentities;

use Domain\Cart\Contracts\CartIdentityStorageContract;

class TokenIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return request()->bearerToken();
    }
}
