<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('user_uuid')) {
            $user = User::where('uuid', $request->get('user_uuid'))->first()->load('logs', 'services', 'social');
        } else {
            $user = auth()->user();
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid'))->first();

        $user->update([
            'status' => $request->get('status'),
        ]);
    }
}
