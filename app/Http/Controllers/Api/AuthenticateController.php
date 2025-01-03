<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\CreateTokenAction;
use App\Actions\Api\RefreshTokenAction;
use App\Enums\ApiErrorCode;
use App\Http\Requests\Api\AuthenticateFormRequest;
use App\Http\Requests\Api\RefreshTokenFormRequest;
use App\Http\Responses\Api\TokenResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateController
{
    public function authenticate(
        AuthenticateFormRequest $request,
        CreateTokenAction $action,
        TokenResponse $response
    ): TokenResponse {
        [$token, $refresh] = $action->handle($request->toDto());

        if ($token === null) {
            return $response->toFailure(
                ApiErrorCode::CREDENTIALS_INVALID,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $response->withTokens($token, $refresh);
    }

    public function logout(): Response
    {
        auth()->logout();

        return response()->noContent();
    }

    public function refresh(
        RefreshTokenFormRequest $request,
        RefreshTokenAction $action,
        TokenResponse $response
    ): TokenResponse {
        [$token, $refresh] = $action->handle($request->input('refresh_token'));

        if ($token === null) {
            return $response->toFailure(
                ApiErrorCode::TOKEN_REFRESH_FAILED,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $response->withTokens($token, $refresh);
    }
}
