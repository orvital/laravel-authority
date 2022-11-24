<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Update the user name and email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        return back()->with($request->updateProfile());
    }
}
