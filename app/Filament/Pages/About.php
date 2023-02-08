<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class About extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.about';

    protected static ?string $navigationGroup = 'Pages';

    // protected static ?string $title = 'Sobre nosotros';

    protected function getTitle(): string{
        if(app()->getLocale() == 'en'){
            return 'About us';
        }elseif(app()->getLocale() == 'fr'){
            return 'À propos de nous';
        }else{
            return 'Sobre nosotros'; 
        }
    }

}
