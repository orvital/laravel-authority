<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Actions\UpdateUserPassword;

class PasswordController extends Controller
{
    /**
     * Update the user password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UpdateUserPassword $action)
    {
        return back()->with($action->update($request->user(), $request->all()));
    }
}
