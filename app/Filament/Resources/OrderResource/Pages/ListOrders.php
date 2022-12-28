<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array{
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableContentFooter(): ?View{
        return view('filament.orders.footer');
    }
}
