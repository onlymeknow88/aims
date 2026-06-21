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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (in_array($guard, ['web', 'dashboard', null])) {
                if (Auth::guard('web')->check() || Auth::guard('dashboard')->check()) {
                    return redirect('/');
                }
            }

            if ($guard == "kpp" && Auth::guard($guard)->check()) {
                return redirect()->route('kpp::dashboard');
            }

            if ($guard == 'document-system') {
                return redirect()->route('document-system::dashboard');
            }

            if ($guard == "ko" && Auth::guard($guard)->check()) {
                return redirect()->route('ko::dashboard');
            }

            if ($guard == "mcu" && Auth::guard($guard)->check()) {
                return redirect()->route('mcu::medical-staff');
            }

            if ($guard == "kplh" && Auth::guard($guard)->check()) {
                return redirect()->route('kplh::lists');
            }
        }

        return $next($request);
    }
}
