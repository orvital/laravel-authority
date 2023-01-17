<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:192'],
            'email' => ['required', 'max:192', 'email', Rule::unique('users')->ignore($this->user)],
            'password' => ['required', 'confirmed', PasswordRule::default()],
        ];
    }
}
