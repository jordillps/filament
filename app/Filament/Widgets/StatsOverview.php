<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\Product;

class StatsOverview extends BaseWidget{

    //Update every 10s
    protected static ?string $pollingInterval = '10s';

    protected function getCards(): array{
        return [
            Card::make('Customers', Customer::query()->count()),
            Card::make('Orders', Order::query()->count()),
            Card::make('Products', Product::query()->count()),
        ];
    }
}
