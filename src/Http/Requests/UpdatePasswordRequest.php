<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password:'.config('authority.web.guard')],
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
    public function updatePassword(): array
    {
        $this->user()->forceFill([
            'password' => Hash::make($this->validated('password')),
        ])->save();

        return ['password' => __('Password Updated')];
    }
}
