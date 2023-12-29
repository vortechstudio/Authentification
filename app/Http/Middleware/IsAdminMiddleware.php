<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(\Auth::check() && \Auth::user()->admin) {
            return $next($request);
        } else {
            session()->flash('error', 'Vous devez être administrateur pour accéder à cette page');
            return redirect()->route('login');
        }
    }
}
