<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke()
    {
        if(\Auth::attempt(['email' => request()->get('email'), "password" => request()->get('password')])) {
            $user = User::find(\Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                "success" => true,
                "token" => $user_token,
                "user" => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
}
