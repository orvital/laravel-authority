<?php

namespace Orvital\Authority\Email\Http\Controllers;

use Illuminate\Routing\Controller;
use Orvital\Authority\Email\Http\Requests\EmailVerifyRequest;

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
