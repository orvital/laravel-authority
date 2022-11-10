<?php

namespace Orvital\Auth\Invites\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Orvital\Auth\Invites\Events\InviteAccepted;
use Orvital\Auth\Invites\Facades\Invite;

class InviteAcceptController extends Controller
{
    /**
     * Display the accept invite view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.invite-accept', ['request' => $request]);
    }

    /**
     * Handle an incoming accept request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required', 'max:192'],
            'name' => ['required', 'string', 'max:192'],
            'email' => ['required', 'max:192', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed', PasswordRule::default()],
        ]);

        // Here we will attempt to accept the invite. If it is successful we
        // will create a new user and persist it to the database.
        Otherwise we will parse the error and return the response.
        $status = Invite::accept(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new InviteAccepted($user));
            }
        );

        // If the invite was successfully accepted, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Invite::INVITE_ACCEPTED
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
    }
}
