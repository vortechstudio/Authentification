<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        \auth()->user()->update([
            "status" => "offline"
        ]);
        Auth::logout();
        Session::flush();

        return redirect()->route('login');
    }
}
