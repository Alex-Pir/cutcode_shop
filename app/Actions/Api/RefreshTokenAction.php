<?php

namespace App\Actions\Api;

use Domain\Auth\JWT;

class RefreshTokenAction
{
    public function __construct(
        private JWT $jwt,
    ) {
    }

    public function handle(string $refreshToken): ?array
    {
        $id = $this->jwt->parse($refreshToken);

        if ($id === null) {
            return null;
        }

        return [
            $this->jwt->create($id),
            $this->jwt->create($id, refresh: true),
        ];
    }
}
