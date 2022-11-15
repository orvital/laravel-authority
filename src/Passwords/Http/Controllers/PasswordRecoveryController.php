<?php

namespace Orvital\Authority\Passwords\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Passwords\Http\Requests\PasswordRecoverRequest;

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
        return back()->with('status', $request->sendResetLink());
    }
}
