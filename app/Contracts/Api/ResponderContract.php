<?php

namespace App\Contracts\Api;


use Symfony\Component\HttpFoundation\Response;
use Throwable;

interface ResponderContract
{
    public function respond(ResponseResolverContract $resolver): Response;
    public function error(Throwable $e): Response;
}
