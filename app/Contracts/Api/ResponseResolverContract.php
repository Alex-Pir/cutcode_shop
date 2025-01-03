<?php

namespace App\Contracts\Api;

interface ResponseResolverContract
{
    public function with(mixed $data = null): static;
    public function resolve(): mixed;
}
