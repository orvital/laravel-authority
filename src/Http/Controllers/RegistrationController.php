<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Facades\Authority;
use Orvital\Authority\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
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
        $user = Authority::register($request->validated());

        return redirect(config('authority.home'));
    }
}
