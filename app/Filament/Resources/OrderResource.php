<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Pedido';

    protected static ?string $pluralModelLabel = 'Pedidos';

    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Select::make('customer_id')->relationship('customer', 'name'),
                    Select::make('priority')->options(['Normal' => 'Normal','Urgent' => 'Urgent']),
                    TextInput::make('subtotal')->type('number')->step('any')->required()->disabled(),
                    TextInput::make('tax')->type('number')->step('any')->required()->disabled(),
                    TextInput::make('total')->type('number')->step('any')->required()->disabled(),
                    Textarea::make('comment')->required()->maxLength(255),
                    DatePicker::make('created_at')->format('d-m-Y')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('priority')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('subtotal')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('tax')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('total')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')
                    ->date('d-m-Y'),
            ])->defaultSort('id', 'DESC')
            ->filters([
                SelectFilter::make('priority')
                    ->options([
                        'Normal' => 'Normal',
                        'Urgent' => 'Urgent',
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\LineOrdersRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
