<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    //Redirect to Index after creating this model
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }
}
