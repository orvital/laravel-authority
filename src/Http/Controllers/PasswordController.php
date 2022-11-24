<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\PasswordUpdateRequest;

class PasswordController extends Controller
{
    /**
     * Update the user name and email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordUpdateRequest $request)
    {
        return back()->with($request->updatePassword());
    }
}
