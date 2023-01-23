<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Filament\Resources\UserResource;
use Filament\Navigation\UserMenuItem;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
         
        });

        // Filament::serving(function () {
        //     Filament::registerUserMenuItems([
        //         UserMenuItem::make()
        //             ->label('Tu perfil')
        //             ->url(UserResource::getUrl('edit', ['record' => auth()->user()]))
        //             ->icon('heroicon-s-user'),
        //         UserMenuItem::make()
        //             ->label('Usuarios')
        //             ->url(UserResource::getUrl())
        //             ->icon('heroicon-s-users'),
        //         // ...
        //     ]);
        // });
       
    }
}
