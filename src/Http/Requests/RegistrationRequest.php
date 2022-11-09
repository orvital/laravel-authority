<?php

namespace Orvital\Auth\Http\Requests;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    /**
     * Log the user out of the application.
     */
    public function register(): void
    {
        // $user = auth()->getProvider()->createModel()->create($this->validated());

        $user = Auth::guard()->getProvider()->createModel()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
    }
}
