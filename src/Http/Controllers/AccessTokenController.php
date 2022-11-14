<?php

namespace Orvital\Auth\Http\Controllers;

use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    /**
     * Show the user API token screen.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.tokens', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Create a new API token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:192'],
        ]);

        $token = $request->user()->createToken($request->name);

        return back()->with('status', explode('|', $token->plainTextToken, 2)[1]);
    }

    /**
     * Delete the given API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->first()->delete();

        return back(303);
    }
}
