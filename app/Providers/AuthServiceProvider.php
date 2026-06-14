<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    protected array $multiGuards = [
        'document-system',
        'kpp',
        'audit',
        'sap',
        'csms',
        'coe',
        'kplh',
        'mcu',
        'pica',
        'ibpr-and-bowtie',
        'field-leadership'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, string $ability) {
            foreach ($this->multiGuards as $guard) {
                $guardUser = Auth::guard($guard)->user();
                if ($guardUser && method_exists($guardUser, 'hasPermissionTo')) {
                    try {
                        if ($guardUser->hasPermissionTo($ability, $guard)) {
                            return true;
                        }
                    } catch (\Throwable) {
                        // Permission tidak terdaftar untuk guard ini – lewati
                    }
                }
            }
            return null;
        });
    }
}
