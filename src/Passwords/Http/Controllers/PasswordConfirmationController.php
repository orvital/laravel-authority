<?php

namespace Orvital\Authority\Passwords\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Passwords\Http\Requests\PasswordConfirmRequest;

class PasswordConfirmationController extends Controller
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
