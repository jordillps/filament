<?php

namespace App\Filament\Resources\LineOrderResource\Pages;

use App\Filament\Resources\LineOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLineOrder extends EditRecord
{
    protected static string $resource = LineOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array{
    //     $data['price'] = $data['price'] / 100;
    //     return $data;
    // }

    // protected function mutateFormDataBeforeSave(array $data): array{
    //     $data['price'] = $data['price'] * 100;
    //     return $data;
    // }

}
