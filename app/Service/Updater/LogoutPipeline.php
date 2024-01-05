<?php

namespace App\Service\Updater;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Salahhusa9\Updater\Contracts\Pipeline;

class LogoutPipeline implements Pipeline
{

    public function handle($content, \Closure $next)
    {
        User::all()->each(function ($user) {
            Auth::login($user);
            $user->update([
                'status' => 'offline',
            ]);
            Auth::logout();
            Session::flush();
        });
    }
}
