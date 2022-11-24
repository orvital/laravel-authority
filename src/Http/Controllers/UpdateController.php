<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\PasswordUpdateRequest;

class UpdateController extends Controller
{
    /**
     * Confirm the user's password.
     *
     * @return mixed
     */
    public function store(PasswordUpdateRequest $request)
    {
        return back()->with($request->updatePassword());
    }
}
