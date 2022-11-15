<?php

namespace Orvital\Authority\Password\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Password\Http\Requests\PasswordResetRequest;

class PasswordResetController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
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
    public function store(PasswordResetRequest $request)
    {
        return redirect()->route('login')->with('status', $request->resetPassword());
    }
}