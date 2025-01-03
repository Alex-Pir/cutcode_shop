<?php

namespace App\Actions\Api;

use App\Dto\AuthenticateDto;
use App\Guards\JWTGuard;
use Domain\Auth\JWT;
use Illuminate\Contracts\Auth\Factory;

final class CreateTokenAction
{
    public function __construct(
        private JWT $jwt,
        private Factory $auth,
    ) {
    }

    public function handle(AuthenticateDto $dto): ?array
    {
        /** @var JWTGuard $guard */
        $guard = $this->auth->guard();

        $id = $guard->retrieveIdByCredentials(
            $dto->getEmail(),
            $dto->getPassword()
        );

        if ($id === null) {
            return null;
        }

        return [
            $this->jwt->create($id),
            $this->jwt->create($id, refresh: true),
        ];
    }
}
