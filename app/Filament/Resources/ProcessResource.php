<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessResource\Pages;
use App\Filament\Resources\ProcessResource\RelationManagers;
use App\Models\Process;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Proceso';

    protected static ?string $pluralModelLabel = 'Procesos';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 4;


    //To search globally in this resource
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('weight')->type('number')->step('any')->rule('numeric')->required(),
                    TextInput::make('price')->type('number')->step('any')->rule('numeric')->required(),
                    TextInput::make('unit')->required()->maxLength(20),
                    Select::make('type')->options(['Product' => 'Product','Service' => 'Service', 'Material' => 'Material']),
                    Select::make('status')->options(['Pending' => 'Pending','Finished' => 'Finished']),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('weight'),
                Tables\Columns\TextColumn::make('price')->money('eur')->sortable()->searchable()->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('unit'),
                Tables\Columns\TextColumn::make('type')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
            ])
            ->filters([
                //
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcesses::route('/'),
            'create' => Pages\CreateProcess::route('/create'),
            'edit' => Pages\EditProcess::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string{
        // return Customer::count();
        return self::getModel()::count();
    }
}
