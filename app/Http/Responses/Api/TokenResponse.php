<?php

namespace App\Http\Responses\Api;

use Symfony\Component\HttpFoundation\Response;

class TokenResponse extends ApiResponse
{
    public function type(): string
    {
        return 'token';
    }

    public function links(): array
    {
        return [
            'self' => route('api.authenticate'),
            'logout' => route('api.logout'),
        ];
    }

    public function withTokens(string $token, string $refreshToken): self
    {
        return $this->toSuccess(
            new ApiData(
                $this->type(),
                $token,
                ['token' => $token, 'refresh_token' => $refreshToken]
            ),
            Response::HTTP_CREATED
        );
    }
}
