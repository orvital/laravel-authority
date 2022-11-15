<?php

namespace Orvital\Authority\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'confirmed', PasswordRule::default()],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ];
    }

    /**
     * Set password confirmation time.
     */
    public function updatePassword()
    {
        $this->user()->forceFill([
            'password' => Hash::make($this->safe('password')),
        ])->save();
    }
}
