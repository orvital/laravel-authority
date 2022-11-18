<?php

namespace Orvital\Authority\Password\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Password\Http\Requests\PasswordConfirmRequest;

class ConfirmationController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('auth.password-confirmation');
    }

    /**
     * Confirm the user's password.
     *
     * @return mixed
     */
    public function store(PasswordConfirmRequest $request)
    {
        $request->confirm();

        return redirect()->intended(config('authority.home'));
    }
}
