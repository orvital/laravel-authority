<?php

namespace Orvital\Authority\Http\Requests;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;

class EmailVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! hash_equals((string) $this->route('id'), (string) $this->user()->getKey())) {
            return false;
        }

        if (! hash_equals((string) $this->route('hash'), sha1($this->user()->getEmailForVerification()))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Fulfill the email verification request.
     */
    public function fulfill(): void
    {
        if (! $this->user()->hasVerifiedEmail() && $this->user()->markEmailAsVerified()) {
            event(new Verified($this->user()));
        }
    }
}
