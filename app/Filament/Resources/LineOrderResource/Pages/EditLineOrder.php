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
}
