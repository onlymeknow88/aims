<?php

namespace App\Providers;

use App\Filament\Pages\Profile;
use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class AdminProfileServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        Profile::class
    ];

    public function configurePackage(Package $package): void
    {
        $package->name = 'admin-profile';
    }

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('My Profile')
                ->url(route('filament.pages.profile'))
                ->icon('heroicon-s-user')
        ];
    }
}
