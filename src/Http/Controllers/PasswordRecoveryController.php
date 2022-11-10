<?php

namespace Orvital\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Orvital\Auth\Http\Requests\PasswordRecoverRequest;

class PasswordRecoveryController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.password-recovery');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PasswordRecoverRequest $request)
    {
        $message = $request->sendResetLink();

        return back()->with('status', $message);

        // $request->validate([
        //     'email' => ['required', 'max:192', 'email'],
        // ]);

        // // We will send the password reset link to this user. Once we have attempted
        // // to send the link, we will examine the response then see the message we
        // // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink($request->only('email'));

        // return $status == Password::RESET_LINK_SENT
        //     ? back()->with('status', __($status))
        //     : back()->withInput($request->only('email'))
        //             ->withErrors(['email' => __($status)]);
    }
}