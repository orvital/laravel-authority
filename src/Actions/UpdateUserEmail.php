<?php

namespace Orvital\Authority\Actions;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserEmail
{
    /**
     * Get the validation rules to apply.
     */
    public function rules($user): array
    {
        return [
            'email' => ['required', 'max:192', 'email', Rule::unique('users')->ignore($user)],
        ];
    }

    /**
     * Validate and update the user's email.
     */
    public function update(mixed $user, array $attributes): array
    {
        $validated = Validator::make($attributes, $this->rules($user))
            ->validateWithBag('updateEmail');

        $user = $user->forceFill($validated);

        if ($user->isDirty('email') && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                $user->getVerifiedAtColumn() => null,
            ]);

            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return ['resend' => __('A new verification link has been sent to your email address.')];
    }
}
