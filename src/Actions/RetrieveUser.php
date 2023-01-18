<?php

namespace Orvital\Authority\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Orvital\Authority\Facades\Authority;

class RetrieveUser
{
    /**
     * Get the validation rules to apply.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'max:192', 'email'],
            'password' => ['required', 'max:192'],
        ];
    }

    /**
     * Validate and retrieve a user.
     */
    public function retrieve(array $attributes): Authenticatable
    {
        $validated = Validator::make($attributes, $this->rules())->validate();

        $user = Authority::findByCredentials($validated);

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }
}
