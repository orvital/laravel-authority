<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Actions\RetrieveUser;

class ApiTokenController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->currentAccessToken();
    }

    public function store(Request $request, RetrieveUser $action)
    {
        $user = $action->retrieve($request->all());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:192'],
        ]);

        $token = $user->createToken($validated['name']);

        return response([
            'token' => explode('|', $token->plainTextToken, 2)[1],
        ]);
    }

    public function destroy(Request $request)
    {
        // Revoke all tokens...
        // $request->user()->tokens()->delete();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
        // $request->user()->tokens()->where('id', $id)->delete();

        return response()->noContent();
    }
}
