<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LineOrderResource\Pages;
use App\Filament\Resources\LineOrderResource\RelationManagers;
use App\Models\LineOrder;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LineOrderResource extends Resource
{
    protected static ?string $model = LineOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')->required()
                    ->required(),
                Forms\Components\TextInput::make('product_id')->required()
                    ->required(),
                Forms\Components\TextInput::make('quantity')->required()->rule('numeric'),
                Forms\Components\TextInput::make('subtotal')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id'),
                Tables\Columns\TextColumn::make('product_id'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('subtotal'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLineOrders::route('/'),
            'create' => Pages\CreateLineOrder::route('/create'),
            'edit' => Pages\EditLineOrder::route('/{record}/edit'),
        ];
    }    
}
