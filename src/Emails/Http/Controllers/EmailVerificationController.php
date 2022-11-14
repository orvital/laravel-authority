<?php

namespace Orvital\Auth\Emails\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(config('authority.home'))
            : view('auth.email-verification');
    }

    /**
     * Send a new email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('authority.home'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}