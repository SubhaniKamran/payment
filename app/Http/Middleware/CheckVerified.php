<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status == 'unverified') {

            Auth::logout();
            $message = 'Your account has not been verified. Please contact administrator.';
            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
