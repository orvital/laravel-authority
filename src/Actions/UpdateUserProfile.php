<?php

namespace Orvital\Authority\Actions;

use Illuminate\Support\Facades\Validator;

class UpdateUserProfile
{
    /**
     * Get the validation rules to apply.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:192'],
        ];
    }

    /**
     * Validate and update the user's profile.
     */
    public function update(mixed $user, array $attributes): array
    {
        $validated = Validator::make($attributes, $this->rules())
            ->validateWithBag('updateProfile');

        $user = $user->forceFill($validated);

        $user->save();

        return ['profile' => __('Profile Updated')];
    }
}
