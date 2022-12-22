<?php

namespace App\Filament\Resources\LineOrderResource\Pages;

use App\Filament\Resources\LineOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLineOrders extends ListRecords
{
    protected static string $resource = LineOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
