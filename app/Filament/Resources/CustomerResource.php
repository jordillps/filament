<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Squire\Models\Country;
use Illuminate\Database\Eloquent\Model;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Illuminate\Support\Str;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // protected static ?string $modelLabel = 'cliente';

    // protected static ?string $pluralModelLabel = 'clientes';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 1;

    //To search globally in this resource
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                Forms\Components\TextInput::make('name')->label(__('global.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')->label(__('global.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->label(__('global.email'))
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')->label(__('global.address'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')->label(__('global.city'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')->label(__('global.postal-code'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('country')->label(__('global.country'))
                    ->options(Country::query()->pluck('name','code_2'))->searchable()->required(),
                    
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('global.name'))->sortable()->searchable()->extraAttributes(['class' => 'bg-gray-200']),
                Tables\Columns\TextColumn::make('phone')->label(__('global.phone'))->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('email')->label(__('global.email'))->sortable()->searchable()->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')->label(__('global.orders'))->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('created_at')->label(__('global.created_at'))->toggleable()
                    ->date('d-m-Y')->extraAttributes(['class' => 'text-right']),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                ->timeFormat('d-m-Y') // Default time format for naming exports
                ->defaultFormat('pdf') // xlsx, csv or pdf
                ->defaultPageOrientation('landscape') // Page orientation for pdf files. portrait or landscape
                ->disableAdditionalColumns(false) // Disable additional columns input
                ->disableFilterColumns(false) // Disable filter columns input
                ->disableFileName(false) // Disable file name input
                ->disableFileNamePrefix(false) // Disable file name prefix
                ->disablePreview(false) // Disable export preview
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false),
                Tables\Actions\DeleteAction::make()->label(false)->disabled(function(Customer $record){
                    if($record->orders->count() > 0){
                        return true;
                    }
                }),
                Tables\Actions\Action::make('exportAsJson')
                ->label(__('Json'))
                ->action(function ($record) {
                    $name = Str::slug($record->name, '_');
                    return response()->streamDownload(function () use ($record) {
                        $return = $record->attributesToArray();
                        echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
                    }, $name . '.json');
                })
                ->tooltip(__('Export'))
                ->icon('heroicon-s-download')
                ->color('primary'),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
    
    //Search for name and email and return name, because is the $recordTitleAttribute
    public static function getGloballySearchableAttributes(): array{
        return ['name', 'email'];
    }

    public static function getNavigationBadge(): ?string{
        // return Customer::count();
        return self::getModel()::count();
    }

    public static function getLabel(): ?string{
        if(app()->getLocale() == 'en'){
            return 'customer';
        }elseif(app()->getLocale() == 'fr'){
            return 'client';
        }else{
            return 'cliente'; 
        }
    }

    public static function getPluralLabel(): ?string{
        if(app()->getLocale() == 'en'){
            return 'customers';
        }elseif(app()->getLocale() == 'fr'){
            return 'clients';
        }else{
            return 'clientes'; 
        }
    }
}
