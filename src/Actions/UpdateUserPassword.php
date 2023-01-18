<?php

namespace Orvital\Authority\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UpdateUserPassword
{
    /**
     * Get the validation rules to apply.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password:'.config('authority.auth.guard')],
            'password' => ['required', 'confirmed', PasswordRule::default()],
        ];
    }

    /**
     * Get custom validator errors messages.
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ];
    }

    /**
     * Validate and update the user's password.
     */
    public function update(mixed $user, array $attributes): array
    {
        $validated = Validator::make($attributes, $this->rules(), $this->messages())
            ->validateWithBag('updatePassword');

        $user->setAuthPassword($validated['password']);
        $user->save();

        return ['password' => __('Password Updated')];
    }
}
