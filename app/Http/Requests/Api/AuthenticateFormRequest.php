<?php

namespace App\Http\Requests\Api;

use App\Dto\AuthenticateDto;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function toDto(): AuthenticateDto
    {
        return new AuthenticateDto(
            $this->input('email'),
            $this->input('password')
        );
    }
}
