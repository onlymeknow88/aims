<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AzureTenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftSSOController extends Controller
{
    /**
     * Redirect to Microsoft Azure AD OAuth.
     */
    public function redirect(?string $module = null): RedirectResponse
    {
        session(['sso_module_guard' => $module ?: 'web']);
        return Socialite::driver('azure')->redirect();
    }

    /**
     * Handle Microsoft Azure AD callback.
     */
    public function callback(): RedirectResponse
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Microsoft: ' . $e->getMessage());
        }

        // Tentukan tenant dari DB atau default
        $tenant = AzureTenant::where('is_active', true)->first();
        if ($tenant && $tenant->allowed_domains) {
            $email = $azureUser->getEmail();
            $domain = '@' . Str::after($email, '@');
            if (!in_array($domain, $tenant->allowed_domains)) {
                return redirect()->route('login')->with('error', 'Domain email Anda tidak diizinkan masuk ke sistem AIMS.');
            }
        }

        $user = User::firstOrCreate(
            ['email' => $azureUser->getEmail()],
            [
                'name'         => $azureUser->getName(),
                'microsoft_id' => $azureUser->getId(),
                'password'     => Hash::make(Str::random(32)),
            ]
        );

        // Update microsoft_id jika belum ada
        if (!$user->microsoft_id) {
            $user->update(['microsoft_id' => $azureUser->getId()]);
        }

        // Login ke central guard
        Auth::guard('web')->login($user, true);

        // Log in to module guard as well if initialized from a specific module
        $moduleGuard = session('sso_module_guard', 'web');
        if ($moduleGuard && $moduleGuard !== 'web' && $moduleGuard !== 'dashboard') {
            if ($user->hasAccessToGuard($moduleGuard)) {
                Auth::guard($moduleGuard)->login($user, true);
            }
        }

        // Selalu redirect ke / terpusat
        return redirect()->intended('/');
    }
}
