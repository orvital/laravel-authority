<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Actions\UpdateUserProfile;

class ProfileController extends Controller
{
    /**
     * Update the user profile.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UpdateUserProfile $action)
    {
        return back()->with($action->update($request->user(), $request->all()));
    }
}
