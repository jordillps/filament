<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Product;
use App\Models\Process;
use Filament\Forms\Components\Select;
use Filament\Tables\Contracts\HasRelationshipTable;
use Filament\Tables\Actions\AttachAction;

class ProcessesRelationManager extends RelationManager
{
    protected static string $relationship = 'processes';

    protected static ?string $modelLabel = 'Proceso';

    protected static ?string $pluralModelLabel = 'Procesos';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price')->money('eur')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('unit'),
                Tables\Columns\TextColumn::make('type')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()->label('Añadir proceso')->preloadRecordSelect()
                ->after(function (HasRelationshipTable $livewire) {
                    $product = Product::where('id', $livewire->ownerRecord->id)->first();
                    $product->updateProductPrice();
                }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->after(function (HasRelationshipTable $livewire) {
                    $product = Product::where('id', $livewire->ownerRecord->id)->first();
                    $product->updateProductPrice();
                }),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
               //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
