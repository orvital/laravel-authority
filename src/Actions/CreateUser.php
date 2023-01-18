<?php

namespace Orvital\Authority\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Orvital\Authority\Facades\Authority;

class CreateUser
{
    /**
     * Get the validation rules to apply.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:192'],
            'email' => ['required', 'max:192', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed', PasswordRule::default()],
        ];
    }

    /**
     * Validate and create a new user.
     */
    public function create(array $attributes): Authenticatable
    {
        $validated = Validator::make($attributes, $this->rules())->validate();

        $user = Authority::register($validated);

        return $user;
    }
}
