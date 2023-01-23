<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Doctrine\DBAL\Query;
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
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Pedido';

    protected static ?string $pluralModelLabel = 'Pedidos';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('id')->disabled(),
                    TextInput::make('order_number'),
                    Select::make('customer_id')->relationship('customer', 'name'),
                    Select::make('priority')->options(['Normal' => 'Normal','Urgent' => 'Urgent']),
                    TextInput::make('subtotal')->type('number')->step('any')->disabled(),
                    TextInput::make('tax')->type('number')->step('any')->disabled(),
                    TextInput::make('total')->type('number')->step('any')->disabled(),
                    Textarea::make('comment')->maxLength(255)
                    ->hint(fn ($state, $component) => 'Quedan: ' . $component->getMaxLength() - strlen($state) . ' caracteres')
                    ->lazy(), //or: reactive() for instant update, but less efficient,
                    DatePicker::make('created_at')->format('d-m-Y')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('order_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable()
                ->url(fn (Order $record) => CustomerResource::getUrl('edit', ['record' => $record->customer])),
                Tables\Columns\BadgeColumn::make('priority')->sortable()->searchable()->color(static function ($state): string {
                    if ($state === 'Urgent') {
                        return 'success';
                    }
                    return 'secondary';
                }),
                Tables\Columns\TextColumn::make('subtotal')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('tax')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('total')->money('eur')->extraAttributes(['class' => 'text-right']),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')
                    ->date('d-m-Y')->sortable(),
            ])
            ->defaultSort('id', 'DESC')
            ->filters([
                SelectFilter::make('priority')
                    ->options([
                        'Normal' => 'Normal',
                        'Urgent' => 'Urgent',
                    ]),
                    Filter::make('created_at')
                        ->form([
                            DatePicker::make('created_from')->format('d-m-Y'),
                            DatePicker::make('created_until')->format('d-m-Y')
                        ])
                        ->query(function ($query,array $data){
                            return $query
                                ->when($data['created_from'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['created_from']))
                                ->when($data['created_until'],
                                fn($query) => $query->whereDate('created_at', '<=', $data['created_until']));
                        })
                        
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
                Tables\Actions\DeleteAction::make()->label(false),
               
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
    
    public static function getNavigationBadge(): ?string{
        // return Customer::count();
        return self::getModel()::count();
    }
}
