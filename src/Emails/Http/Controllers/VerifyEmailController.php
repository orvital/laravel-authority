<?php

namespace Orvital\Auth\Emails\Http\Controllers;

use Illuminate\Routing\Controller;
use Orvital\Auth\Emails\Http\Requests\EmailVerifyRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerifyRequest $request)
    {
        $request->fulfill();

        return redirect()->intended(config('authority.home').'?verified=1');
    }
}
