<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->check()) {
            $role = Auth::user()->role; 
        
            switch ($role) {
                case 'admin':
                    return redirect('/admin_dashboard');
                    break;
                case 'merchant':
                    return redirect('/merchant_dashboard');
                    break; 
            }
        }
        return $next($request);
    }
}
