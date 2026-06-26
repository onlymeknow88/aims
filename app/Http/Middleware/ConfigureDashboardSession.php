<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConfigureDashboardSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $filamentPath = config('filament.path', 'admin');
        $isFilamentRequest = ($request->is($filamentPath . '*') 
            || $request->is('admin*') 
            || $request->is('filament*') 
            || $request->is('livewire/message/filament*')
            || str_contains($request->header('referer', ''), '/' . $filamentPath));

        if (!$isFilamentRequest) {
            // Set dedicated session cookie name for main dashboard to avoid interfering with Filament
            config(['session.cookie' => 'aims_dashboard_session']);
            
            // Set session lifetime to 1x24 hours (1440 minutes) for auto logout requirement
            config(['session.lifetime' => 1440]);
        }

        return $next($request);
    }
}
