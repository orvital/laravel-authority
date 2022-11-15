<?php

namespace Orvital\Authority\User\Http\Requests;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:192'],
            'email' => ['required', 'max:192', 'email', Rule::unique('users')->ignore($this->user())],
        ];
    }

    /**
     * Set password confirmation time.
     */
    public function updateProfile(): bool
    {
        $user = $this->user();

        $user->forceFill($this->validated());

        if ($user->isDirty('email') && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                $user->getVerifiedAtColumn() => null,
            ])->save();

            $user->sendEmailVerificationNotification();

            return true;
        }

        $user->save();

        return false;
    }
}
