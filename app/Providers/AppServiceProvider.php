<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Access\dateSetup;
use Laravel\Socialite\Facades\Socialite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Register Socialite Azure driver
        if (class_exists(Socialite::class)) {
            try {
                Socialite::extend('azure', function ($app) {
                    $tenant = \App\Models\AzureTenant::where('is_active', true)->first();
                    $config = $tenant ? [
                        'client_id'     => $tenant->client_id,
                        'client_secret' => decrypt($tenant->client_secret),
                        'redirect'      => $tenant->redirect_uri,
                        'tenant'        => $tenant->tenant_id,
                    ] : $app['config']['services.azure'];

                    return Socialite::buildProvider(
                        \SocialiteProviders\Azure\Provider::class, $config
                    );
                });
            } catch (\Throwable $e) {
                // Prevent crash if DB is not ready or keys are missing
            }
        }

        //simpan bulan tahun
        try {
            dateSetup::setYear();
        } catch (\Throwable $e) {
        }
    }
}
