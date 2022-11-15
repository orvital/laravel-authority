<?php

namespace Orvital\Authority\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\User\Http\Requests\UpdatePasswordRequest;
use Orvital\Authority\User\Http\Requests\UpdateProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user profile.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $emailResent = $request->updateProfile();

        return back()->with('profile', __('Profile Updated'));
    }

    /**
     * Update the user password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UpdatePasswordRequest $request)
    {
        $request->updatePassword();

        return back()->with('password', __('Password Updated'));
    }
}
