<?php

namespace App\Filament\Resources\LineOrderResource\Pages;

use App\Filament\Resources\LineOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLineOrder extends CreateRecord
{
    protected static string $resource = LineOrderResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array{
    //     $data['price'] = $data['price'] * 100;

    //     return $data;
    // }
}
