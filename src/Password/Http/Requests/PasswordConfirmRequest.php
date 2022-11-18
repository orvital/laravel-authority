<?php

namespace Orvital\Authority\Password\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PasswordConfirmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'max:192', 'email'],
            'password' => ['required', 'max:192'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->user()->email,
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! auth()->validate($this->validated())) {
                $validator->errors()->add('password', trans('auth.password'));
            }
        });
    }

    /**
     * Set password confirmation time.
     */
    public function confirm()
    {
        $this->session()->passwordConfirmed();
    }
}
