<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Orvital\Authority\Facades\Authority;

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
            'name' => ['required', 'max:192'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createToken()
    {
        $user = Authority::findByCredentials($this->only(['email', 'password']));

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($this->name);
    }
}
