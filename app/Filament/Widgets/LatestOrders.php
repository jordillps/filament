<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    //By default, chart widgets refresh their data every 5 seconds.
    //To disable:  protected static ?string $pollingInterval = null;
    protected static ?string $pollingInterval = '10s';
    
    public static ?int $sort = 2;

    protected int| string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder{
        //Create the query
        return Order::latest()->take(5);
    }

    protected function getTableColumns(): array{
        return [
            Tables\Columns\TextColumn::make('customer.name'),
            Tables\Columns\TextColumn::make('total')->money('eur'),
            Tables\Columns\TextColumn::make('created_at')->label('Fecha')->date('d-m-Y'),
        ];
    }

    protected function isTablePaginationEnabled(): bool{
        return false;
    }
}
