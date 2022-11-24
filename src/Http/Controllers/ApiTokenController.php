<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\ApiTokenRequest;

class ApiTokenController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->currentAccessToken();
    }

    public function destroy(Request $request, string $id)
    {
        // Revoke all tokens...
        // $request->user()->tokens()->delete();

        // Revoke current token
        // $request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
        $request->user()->tokens()->where('id', $id)->delete();

        return response()->noContent();
    }
}
