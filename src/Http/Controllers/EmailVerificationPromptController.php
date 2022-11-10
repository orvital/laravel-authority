<?php

namespace Orvital\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(config('auth.home'))
                    : view('auth.email-verification');
    }
}
