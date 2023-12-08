<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            "success" => true,
            "user" => $user
        ]);
    }
}
