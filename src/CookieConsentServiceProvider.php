<?php

namespace Slimani\CookieConsent;

use Livewire\Livewire;
use Slimani\CookieConsent\Livewire\CookieConsent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CookieConsentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-cookie-consent')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        Livewire::component('cookie-consent', CookieConsent::class);
    }
}
