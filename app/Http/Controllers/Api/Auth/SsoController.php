<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SsoController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->query('token');

        $user = User::where('remember_token', $token)->first();

        if(!$user) {
            return response()->json([
                "error" => "Clé de chiffrement invalide"
            ], 401);
        }

        \Auth::login($user);
        return redirect($request->query('redirect_uri'));
    }
}
