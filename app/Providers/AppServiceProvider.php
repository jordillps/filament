<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
