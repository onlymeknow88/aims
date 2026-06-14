<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        $centralUser = $this->auth->guard('web')->user() ?: $this->auth->guard('dashboard')->user();

        foreach ($guards as $guard) {
            // Sudah login di guard target? Langsung lewat.
            if ($this->auth->guard($guard)->check()) {
                if ($guard === 'mcu') {
                    session(['login_email' => $this->auth->guard($guard)->user()->email]);
                }
                return $this->auth->shouldUse($guard);
            }

            // Sudah login di web/dashboard? Cek akses ke guard target lalu auto-login.
            if ($centralUser && $this->userHasAccessToGuard($centralUser, $guard)) {
                $this->auth->guard($guard)->login($centralUser);
                if ($guard === 'mcu') {
                    session(['login_email' => $centralUser->email]);
                }
                return $this->auth->shouldUse($guard);
            }
        }

        // Sudah login tapi tidak punya akses ke guard ini
        if ($centralUser) {
            abort(403, 'Anda tidak memiliki hak akses ke modul ini.');
        }

        $this->unauthenticated($request, $guards);
    }

    protected function userHasAccessToGuard($user, $guard): bool
    {
        if (in_array($guard, ['web', null, 'admin', 'dashboard'])) {
            return true;
        }

        return $user->hasAccessToGuard($guard);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
        return null;
    }
}
