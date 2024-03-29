<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(): void
    {
        $limiterKey = Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());

        // Check if the request has too many failed login attempts.
        if (RateLimiter::tooManyAttempts($limiterKey, 5)) {
            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($limiterKey);

            throw ValidationException::withMessages([
                'email' => [
                    trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)]),
                ],
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }

        // Attempt to authenticate a user using the given credentials.
        if (! Auth::attempt($this->validated(), $this->boolean('remember'))) {
            RateLimiter::hit($limiterKey);

            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $this->session()->regenerate();

        RateLimiter::clear($limiterKey);
    }
}
