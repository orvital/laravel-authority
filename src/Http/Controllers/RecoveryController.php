<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\PasswordRecoverRequest;
use Orvital\Authority\Http\Requests\PasswordResetRequest;

class RecoveryController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
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

    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, string $token)
    {
        return view('auth.password-reset', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PasswordResetRequest $request, string $token)
    {
        return redirect()->route('login')->with('status', $request->resetPassword());
    }
}
