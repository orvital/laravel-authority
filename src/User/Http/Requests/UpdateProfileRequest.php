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
     * Update profile
     */
    public function updateProfile(): array
    {
        $user = $this->user()->forceFill($this->validated());

        $response = [
            'profile' => __('Profile Updated'),
        ];

        if ($user->isDirty('email') && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                $user->getVerifiedAtColumn() => null,
            ]);

            $user->sendEmailVerificationNotification();

            $response['resend'] = __('A new verification link has been sent to your email address.');
        }

        $user->save();

        return $response;
    }

    /**
     * Set password confirmation time.
     */
    public function resendEmail(): array
    {
        if ($this->user()->hasVerifiedEmail()) {
            return back()->with('status', 'verification-link-sent');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');

        $user = $this->user()->forceFill($this->validated());

        if ($this->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('authority.home'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
