<?php

namespace Orvital\Authority\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Orvital\Authority\Http\Requests\TokenCreateRequest;

class TokenController extends Controller
{
    public function store(TokenCreateRequest $request)
    {
        $token = $request->createToken();

        // return back()->with('status', explode('|', $token->plainTextToken, 2)[1]);

        return response([
            'token' => $token->plainTextToken,
        ]);
    }
}
