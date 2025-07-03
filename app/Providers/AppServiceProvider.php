<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Configuración')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Inscripciones')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Otros')
                    ->collapsed(),
            ]);
        });
    }
}
