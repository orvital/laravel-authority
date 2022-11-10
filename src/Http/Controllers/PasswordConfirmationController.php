<?php

namespace Orvital\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Auth\Http\Requests\PasswordConfirmRequest;

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

        return redirect()->intended(config('auth.home'));
    }
}
