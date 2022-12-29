<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    //Redirect to Index after creating this model
    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }

    //Check something before edit
    protected function beforeFill(){
        if ($this->record->orders()->count() >= 2) {
            $this->notify('danger', 'This customer has 2 orders or more');

            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

   
}
