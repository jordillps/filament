<?php

namespace App\Filament\Resources\ProcessResource\Pages;

use App\Filament\Resources\ProcessResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProcess extends CreateRecord
{
    protected static string $resource = ProcessResource::class;

    //Redirect to Index after creating this model
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
