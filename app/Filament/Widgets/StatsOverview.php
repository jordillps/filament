<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;
use App\Models\Product;
use Akaunting\Money\Money;

class StatsOverview extends BaseWidget{

    public static ?int $sort = 1;

    protected function getCards(): array{
        return [
            Card::make('Customers', Customer::query()->count()),
            // Card::make('Orders', Order::query()->count()),
            Card::make('Orders this month', Order::where('created_at','>=', now()->subDays(30))->count()),
            Card::make('Total this month', Money::EUR(Order::where('created_at','>=', now()->subDays(30))->sum('total')), true),
            // Card::make('Products', Product::query()->count()),
        ];
    }
}
