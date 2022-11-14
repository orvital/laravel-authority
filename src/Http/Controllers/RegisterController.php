<?php

namespace Orvital\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Auth\Http\Requests\RegistrationRequest;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationRequest $request)
    {
        $request->register();

        return redirect(config('authority.home'));
    }
}
