<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Actions\UpdateUserEmail;

class EmailController extends Controller
{
    /**
     * Update the user email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UpdateUserEmail $action)
    {
        return back()->with($action->update($request->user(), $request->all()));
    }
}
