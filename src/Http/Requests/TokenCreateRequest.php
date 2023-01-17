<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TokenCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'max:192', 'email'],
            'password' => ['required', 'max:192'],
            'token_name' => ['required', 'max:192'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createToken()
    {
        $provider = Auth::guard()->getProvider();

        $user = $provider->retrieveByCredentials($this->only('email'));

        if (! $user || ! $provider->validateCredentials($user, $this->only('password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($this->token_name);
    }
}
