<?php

namespace Orvital\Authority\Email\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Email\Http\Requests\EmailVerifyRequest;

class VerificationController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @return mixed
     */
    public function index(Request $request)
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

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(EmailVerifyRequest $request, string $id, string $hash)
    {
        $request->fulfill();

        return redirect()->intended(config('authority.home').'?verified=1');
    }
}
