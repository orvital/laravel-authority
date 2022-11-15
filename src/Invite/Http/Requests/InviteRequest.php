<?php

namespace Orvital\Authority\Invite\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Orvital\Authority\Invite\Facades\Invite;

class InviteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'max:192', 'email'],
        ];
    }

    /**
     * Send invite link.
     */
    public function sendInviteLink(): string
    {
        // We will send the invite link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Invite::send($this->validated());

        if ($status !== Invite::INVITE_SENT) {
            throw ValidationException::withMessages([
                'email' => [trans($status)],
            ]);
        }

        return trans($status);
    }
}
