<?php

namespace Orvital\Authority\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Auth\Http\Requests\AccessTokenRequest;

class AccessTokenController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->currentAccessToken();
    }

    public function store(AccessTokenRequest $request)
    {
        $token = $request->createToken();

        // return back()->with('status', explode('|', $token->plainTextToken, 2)[1]);

        return response([
            'token' => $token->plainTextToken,
        ]);
    }

    public function destroy(Request $request)
    {
        // Revoke all tokens...
        // $request->user()->tokens()->delete();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
        // $request->user()->tokens()->where('id', $tokenId)->delete();

        return response()->noContent();
    }
}
