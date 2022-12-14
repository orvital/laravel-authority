<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\PasswordConfirmRequest;

class ConfirmationController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('auth.unlock');
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
